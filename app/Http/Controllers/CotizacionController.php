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
            'cliente_id'        => 'required|exists:clientes,id',
            'fecha_emision'     => 'required|date',
            'items'             => 'required|array|min:1',
            'items.*.cantidad'  => 'required|numeric|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'items.*.descripcion'     => 'required|string',
            'items.*.unidad_medida'   => 'required|string',
            'forma_pago'        => 'nullable|string',
            'lugar_entrega'     => 'nullable|string',
            'tiempo_entrega'    => 'nullable|string',
            'garantia'          => 'nullable|string',
            'validez_oferta'    => 'nullable|string',
            'clausula_despedida'=> 'nullable|string',
            'nombre_firmante'   => 'nullable|string',
            'total_letras'      => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $cotizacion = new Cotizacion();
            $cotizacion->folio = $this->generarFolio(); // Corregido el llamado sin parámetros
            $cotizacion->cliente_id = $request->cliente_id;
            $cotizacion->fecha_emision = $request->fecha_emision;
            $cotizacion->estado = 'pendiente';
            $cotizacion->creada_por = auth()->id() ?? 1;
            
            // Campos comerciales individuales añadidos
            $cotizacion->lugar_entrega = $request->lugar_entrega;
            $cotizacion->tiempo_entrega = $request->tiempo_entrega;
            $cotizacion->garantia = $request->garantia;
            $cotizacion->forma_pago = $request->forma_pago;
            $cotizacion->validez_oferta = $request->validez_oferta;
            $cotizacion->clausula_despedida = $request->clausula_despedida;
            $cotizacion->nombre_firmante = $request->nombre_firmante;
            $cotizacion->total_letras = $request->total_letras;

            $cotizacion->subtotal = 0;
            $cotizacion->total = 0;
            $cotizacion->save();

            $subtotal = 0;

            // 1. Guardar Ítems de la Oferta Económica (tipo comercial)
            foreach ($request->items as $item) {
                $itemTotal = $item['cantidad'] * $item['precio_unitario'];

                $cotizacion->items()->create([
                    'cantidad' => $item['cantidad'],
                    'unidad_medida' => $item['unidad_medida'],
                    'descripcion' => $item['descripcion'],
                    'precio_unitario' => $item['precio_unitario'],
                    'total' => $itemTotal,
                    'tipo' => 'comercial' // Diferenciador
                ]);

                $subtotal += $itemTotal;
            }

            // 2. Guardar Detalles de Servicios o Materiales Técnicos (Monto 0)
            if ($request->has('detalles')) {
                foreach ($request->detalles as $detalle) {
                    if (!empty($detalle['descripcion'])) {
                        $cotizacion->items()->create([
                            'cantidad' => 1,
                            'unidad_medida' => 'N/A',
                            'descripcion' => $detalle['descripcion'],
                            'precio_unitario' => 0,
                            'total' => 0,
                            'tipo' => $detalle['tipo'] // 'servicio' o 'material'
                        ]);
                    }
                }
            }

            $cotizacion->update([
                'subtotal' => $subtotal,
                'total' => $subtotal
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
        $empresa = EmpresaConfig::find(1) ?? new EmpresaConfig();

        // Separamos las colecciones para estructurar el PDF/Vista limpia
        $itemsComerciales = $cotizacion->items->where('tipo', 'comercial');
        $detallesTecnicos = $cotizacion->items->whereIn('tipo', ['servicio', 'material']);

        return view('cotizaciones.show', compact('cotizacion', 'empresa', 'itemsComerciales', 'detallesTecnicos'));
    }

    /**
     * Formulario Editar
     */
    public function edit(Cotizacion $cotizacion)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $empresa = EmpresaConfig::find(1) ?? new EmpresaConfig();
        $cotizacion->load('items');

        $itemsComerciales = $cotizacion->items->where('tipo', 'comercial');
        $detallesTecnicos = $cotizacion->items->whereIn('tipo', ['servicio', 'material']);

        return view('cotizaciones.edit', compact('cotizacion', 'clientes', 'empresa', 'itemsComerciales', 'detallesTecnicos'));
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
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.unidad_medida' => 'required|string|max:255',
            'items.*.descripcion' => 'required|string',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'total_letras' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Actualizar cabecera con bloques individuales comerciales
            $cotizacion->update([
                'fecha_emision' => $request->fecha_emision,
                'cliente_id' => $request->cliente_id,
                'lugar_entrega' => $request->lugar_entrega,
                'tiempo_entrega' => $request->tiempo_entrega,
                'garantia' => $request->garantia,
                'forma_pago' => $request->forma_pago,
                'validez_oferta' => $request->validez_oferta,
                'clausula_despedida' => $request->clausula_despedida,
                'nombre_firmante' => $request->nombre_firmante,
                'total_letras' => $request->total_letras,
            ]);

            // Limpiar relaciones previas para rescribir la tabla relacional sin duplicar
            $cotizacion->items()->delete();
            $subtotal = 0;

            // 1. Re-guardar Oferta Económica
            foreach ($request->items as $item) {
                $totalItem = $item['cantidad'] * $item['precio_unitario'];

                $cotizacion->items()->create([
                    'cantidad' => $item['cantidad'],
                    'unidad_medida' => $item['unidad_medida'],
                    'descripcion' => $item['descripcion'],
                    'precio_unitario' => $item['precio_unitario'],
                    'total' => $totalItem,
                    'tipo' => 'comercial'
                ]);

                $subtotal += $totalItem;
            }

            // 2. Re-guardar Detalles Técnicos
            if ($request->has('detalles')) {
                foreach ($request->detalles as $detalle) {
                    if (!empty($detalle['descripcion'])) {
                        $cotizacion->items()->create([
                            'cantidad' => 1,
                            'unidad_medida' => 'N/A',
                            'descripcion' => $detalle['descripcion'],
                            'precio_unitario' => 0,
                            'total' => 0,
                            'tipo' => $detalle['tipo']
                        ]);
                    }
                }
            }

            $cotizacion->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
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
     * Generador de Folio
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