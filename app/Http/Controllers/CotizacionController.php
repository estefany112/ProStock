<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\EmpresaConfig;
use App\Models\ItemCotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    /**
     * Listado con búsqueda relacional
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));
        $estado = $request->get('estado', '');

        $cotizaciones = Cotizacion::with('cliente')
            ->when($estado, function ($query) use ($estado) {
                $query->where('estado', $estado);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('folio', 'like', "%{$search}%")
                      ->orWhereHas('cliente', function ($qCliente) use ($search) {
                          $qCliente->where('nombre', 'like', "%{$search}%")
                                   ->orWhere('nit', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('cotizaciones.index', compact('cotizaciones', 'search'));
    }

    /**
     * Formulario Crear
     */
    public function create()
    {
        $empresa = EmpresaConfig::find(1) ?? new EmpresaConfig();
        $clientes = Cliente::orderBy('nombre')->get();
        return view('cotizaciones.create', compact('clientes', 'empresa'));
    }

    /**
     * Almacenar seguro en BD
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_emision' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.unidad_medida' => 'required|string|max:255',
            'items.*.descripcion' => 'required|string',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $cotizacion = new Cotizacion();
            $cotizacion->folio = $this->generarFolio($request->cliente_id);
            $cotizacion->cliente_id = $request->cliente_id;
            $cotizacion->fecha_emision = $request->fecha_emision;
            $cotizacion->estado = 'pendiente';
            $cotizacion->creada_por = auth()->id() ?? 1; // Corregido según tu columna de MySQL
            
            // Atributos base obligatorios
            $cotizacion->subtotal = 0;
            $cotizacion->total = 0;
            $cotizacion->save();

            $subtotal = 0;

            foreach ($request->items as $item) {
                $itemTotal = $item['cantidad'] * $item['precio_unitario'];

                $cotizacion->items()->create([
                    'cantidad' => $item['cantidad'],
                    'unidad_medida' => $item['unidad_medida'],
                    'descripcion' => $item['descripcion'],
                    'precio_unitario' => $item['precio_unitario'],
                    'total' => $itemTotal, // Sincronizado a tu columna 'total' de BD
                ]);

                $subtotal += $itemTotal;
            }

            $total = $subtotal;

            $cotizacion->update([
                'subtotal' => $subtotal,
                'total' => $total
            ]);

            DB::commit();

            return redirect()
                ->route('cotizaciones.index')
                ->with('success', 'Cotización creada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => 'Error al procesar el guardado: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Ver Ficha Única
     */
    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load('items', 'cliente');
        return view('cotizaciones.show', compact('cotizacion'));
    }

    /**
     * Formulario Editar
     */
    public function edit(Cotizacion $cotizacion)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $cotizacion->load('items');
        return view('cotizaciones.edit', compact('cotizacion', 'clientes'));
    }

    /**
     * Actualizar Cambios
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_emision' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.unidad_medida' => 'required|string|max:255',
            'items.*.descripcion' => 'required|string',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $cotizacion->update([
                'fecha_emision' => $request->fecha_emision,
                'cliente_id' => $request->cliente_id,
            ]);

            $cotizacion->items()->delete();
            $subtotal = 0;

            foreach ($request->items as $item) {
                $totalItem = $item['cantidad'] * $item['precio_unitario'];

                $cotizacion->items()->create([
                    'cantidad' => $item['cantidad'],
                    'unidad_medida' => $item['unidad_medida'],
                    'descripcion' => $item['descripcion'],
                    'precio_unitario' => $item['precio_unitario'],
                    'total' => $totalItem,
                ]);

                $subtotal += $totalItem;
            }

            $total = $subtotal;

            $cotizacion->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            DB::commit();

            return redirect()
                ->route('cotizaciones.index')
                ->with('success', 'Cotización actualizada de forma correcta.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    /**
     * Destruir
     */
    public function destroy(Cotizacion $cotizacion)
    {
        try {
            $cotizacion->items()->delete();
            $cotizacion->delete();
            return redirect()->route('cotizaciones.index')->with('success', 'Registro eliminado.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Imposible eliminar: ' . $e->getMessage()]);
        }
    }

    /**
     * Generador de Folio Ultra Compacto Empresarial (10 Caracteres)
     * Estructura: [USER_3_LETRAS][MES_2_DIGITOS][CORRELATIVO_3_DIGITOS][AÑO_2_DIGITOS]
     * Ejemplo: SDI0500126
     */
    private function generarFolio()
    {
        $user = auth()->user();
        $userCode = 'USR'; 
        
        if ($user && $user->name) {
            $nameClean = preg_replace('/[^A-Za-z0-9\s]/', '', $user->name);
            $palabras = explode(' ', preg_replace('/\s+/', ' ', trim($nameClean)));
            
            if (count($palabras) >= 3) {
                $userCode = substr($palabras[0], 0, 1) . substr($palabras[1], 0, 1) . substr($palabras[2], 0, 1);
            } elseif (count($palabras) == 2) {
                $userCode = substr($palabras[0], 0, 2) . substr($palabras[1], 0, 1);
            } else {
                $userCode = substr($palabras[0], 0, 3);
            }
        }

        $userCode = strtoupper(str_pad(substr($userCode, 0, 3), 3, 'X'));

        $mes = date('m');

        $ultima = Cotizacion::latest('id')->first();
        $numero = $ultima ? $ultima->id + 1 : 1;
        $correlativo = str_pad($numero, 3, '0', STR_PAD_LEFT);

        $anioCorto = date('y');

        return "{$userCode}.{$mes}{$correlativo}.{$anioCorto}";
    }
    
}