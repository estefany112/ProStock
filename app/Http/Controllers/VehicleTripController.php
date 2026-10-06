<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\VehicleTrip;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\VehicleChecklistCatalog;
use App\Models\VehicleChecklist;
use Illuminate\Support\Facades\Storage;

class VehicleTripController extends Controller
{

  
    /**
     * Mostrar el control general de viajes de vehículos.
     */
    public function index()
    {
        $trips = VehicleTrip::with([
            'vehicle',
            'driver',
            'registeredByEmployee',
            'passengers.employee',
        ])
            ->orderByRaw("
                CASE
                    WHEN status = 'EN_USO' THEN 1
                    WHEN status = 'PENDIENTE' THEN 2
                    WHEN status = 'NO_AUTORIZADO' THEN 3
                    WHEN status = 'RETORNADO' THEN 4
                    ELSE 5
                END
            ")
            ->orderByDesc('departure_at')
            ->paginate(15);

        return view('vehicle_trips.index', compact('trips'));
    }

    public function show(VehicleTrip $trip)
    {
        $trip->load([
            'vehicle',
            'driver',
            'registeredByEmployee',
            'returnedByEmployee',
            'passengers.employee',

            'checklist' => function ($query) {
                $query->with([
                    'items' => function ($query) {
                        $query->with([
                            'catalog',
                            'photos',
                        ]);
                    },
                ]);
            },
        ]);

        return view('vehicle_trips.show', compact('trip'));
    }

    /**
     * Mostrar formulario para registrar una salida.
     */
    public function createDeparture()
    {
        // =====================================================
        // 1. VEHÍCULOS QUE NO TIENEN UNA SALIDA ACTIVA
        // =====================================================

        $vehicles = Vehiculo::whereDoesntHave('trips', function ($query) {
            $query->where('status', 'EN_USO');
        })
            ->orderBy('numero_interno')
            ->get();

        // =====================================================
        // 2. CONDUCTORES CON LICENCIA VIGENTE
        // =====================================================

        $drivers = Employee::where('active', true)
            ->whereHas('licenses', function ($query) {
                $query->whereDate(
                    'expires_at',
                    '>=',
                    now()->toDateString()
                );
            })
            ->orderBy('name')
            ->get();

        // =====================================================
        // 3. EMPLEADOS DISPONIBLES COMO ACOMPAÑANTES
        // =====================================================

        $employees = Employee::where('active', true)
            ->orderBy('name')
            ->get();

        $checklistItems = VehicleChecklistCatalog::where('active', true)
            ->orderBy('sort_order')
            ->get();

        return view('vehicle_trips.create', compact(
            'vehicles',
            'drivers',
            'employees',
            'checklistItems'
        ));
    }

    /**
     * Registrar la salida de un vehículo.
     */
    public function storeDeparture(Request $request)
    {
        // =====================================================
        // 1. OBTENER CATÁLOGO ACTIVO DEL CHECKLIST
        // =====================================================

        $checklistCatalog = VehicleChecklistCatalog::where('active', true)
            ->orderBy('sort_order')
            ->get();

        // =====================================================
        // 2. REGLAS GENERALES
        // =====================================================

        $rules = [
            'vehicle_id' => [
                'required',
                'exists:vehiculos,id',
            ],

            'driver_id' => [
                'required',
                'exists:employees,id',
            ],

            'registered_by_employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'departure_at' => [
                'required',
                'date',
            ],

            'departure_mileage' => [
                'required',
                'integer',
                'min:0',
            ],

            'departure_fuel' => [
                'required',
                'in:1/4,1/2,3/4,Lleno',
            ],

            'destination' => [
                'required',
                'string',
                'max:255',
            ],

            'project_id' => [
                'nullable',
                'integer',
            ],

            'passengers' => [
                'nullable',
                'array',
            ],

            'passengers.*' => [
                'integer',
                'distinct',
                'exists:employees,id',
            ],

            'checklist' => [
                'required',
                'array',
            ],
        ];

        // =====================================================
        // 3. REGLAS DINÁMICAS DEL CHECKLIST
        // =====================================================

        foreach ($checklistCatalog as $catalogItem) {

            $itemId = $catalogItem->id;

            // ---------------------------------------------
            // Respuesta
            // ---------------------------------------------

            if ($catalogItem->response_type === 'FUEL') {
                $rules["checklist.{$itemId}.response"] = [
                    'required',
                    'in:1/4,1/2,3/4,LLENO',
                ];
            } else {
                $rules["checklist.{$itemId}.response"] = [
                    'required',
                    'in:OK,MAL_FUNCIONAMIENTO,FALLA',
                ];
            }

            // ---------------------------------------------
            // Observación
            // ---------------------------------------------

            $rules["checklist.{$itemId}.observation"] = [
                'nullable',
                'string',
                'max:2000',
            ];

            // ---------------------------------------------
            // Fotografías
            // ---------------------------------------------

            $rules["checklist.{$itemId}.photos"] = [
                'nullable',
                'array',
                'max:5',
            ];

            $rules["checklist.{$itemId}.photos.*"] = [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:15360',
            ];

            // Foto siempre obligatoria.
            if ($catalogItem->photo_requirement === 'REQUIRED') {
                $rules["checklist.{$itemId}.photos"] = [
                    'required',
                    'array',
                    'min:1',
                    'max:5',
                ];
            }
        }

        // =====================================================
        // 4. VALIDAR
        // =====================================================

        $validated = $request->validate($rules);

        // =====================================================
        // 5. VALIDAR FOTOS Y OBSERVACIONES CUANDO HAY PROBLEMA
        // =====================================================

        foreach ($checklistCatalog as $catalogItem) {

            $itemId = $catalogItem->id;

            $response =
                $validated['checklist'][$itemId]['response'];

            $observation =
                $validated['checklist'][$itemId]['observation']
                ?? null;

            /*
            * Si el punto está configurado ON_ISSUE y existe
            * MAL_FUNCIONAMIENTO o FALLA, exigimos fotografía.
            */
            if (
                $catalogItem->photo_requirement === 'ON_ISSUE'
                && in_array(
                    $response,
                    ['MAL_FUNCIONAMIENTO', 'FALLA'],
                    true
                )
            ) {
                if (!$request->hasFile(
                    "checklist.{$itemId}.photos"
                )) {
                    throw ValidationException::withMessages([
                        "checklist.{$itemId}.photos" =>
                            "Debes adjuntar una fotografía para {$catalogItem->name} cuando existe un problema.",
                    ]);
                }
            }

            /*
            * Cuando existe un problema también exigimos
            * explicación escrita.
            */
            if (
                in_array(
                    $response,
                    ['MAL_FUNCIONAMIENTO', 'FALLA'],
                    true
                )
                && blank($observation)
            ) {
                throw ValidationException::withMessages([
                    "checklist.{$itemId}.observation" =>
                        "Debes indicar una observación cuando reportas un problema en {$catalogItem->name}.",
                ]);
            }
        }

        // =====================================================
        // 6. OBTENER CONDUCTOR
        // =====================================================

        $driver = Employee::with('licenses')
            ->findOrFail($validated['driver_id']);

        // =====================================================
        // 7. VALIDAR LICENCIA VIGENTE
        // =====================================================

        $hasValidLicense = $driver->licenses()
            ->whereDate(
                'expires_at',
                '>=',
                now()->toDateString()
            )
            ->exists();

        if (!$hasValidLicense) {
            throw ValidationException::withMessages([
                'driver_id' =>
                    'El empleado seleccionado no tiene una licencia de conducir vigente.',
            ]);
        }

        // =====================================================
        // 8. VALIDAR VEHÍCULO DISPONIBLE
        // =====================================================

        $vehicleInUse = VehicleTrip::where(
            'vehicle_id',
            $validated['vehicle_id']
        )
            ->where('status', 'EN_USO')
            ->exists();

        if ($vehicleInUse) {
            throw ValidationException::withMessages([
                'vehicle_id' =>
                    'El vehículo seleccionado ya tiene una salida activa.',
            ]);
        }

        // =====================================================
        // 9. VALIDAR CONDUCTOR VS ACOMPAÑANTES
        // =====================================================

        $passengers = $validated['passengers'] ?? [];

        if (
            in_array(
                $validated['driver_id'],
                $passengers
            )
        ) {
            throw ValidationException::withMessages([
                'passengers' =>
                    'El conductor no puede registrarse también como acompañante.',
            ]);
        }

        // =====================================================
        // 10. CALCULAR RESULTADO DEL CHECKLIST
        // =====================================================

        $hasFailure = false;
        $hasObservation = false;

        foreach ($checklistCatalog as $catalogItem) {

            $response =
                $validated['checklist'][$catalogItem->id]['response'];

            if ($response === 'FALLA') {

                if ($catalogItem->is_critical) {
                    $hasFailure = true;
                } else {
                    $hasObservation = true;
                }

            } elseif ($response === 'MAL_FUNCIONAMIENTO') {

                $hasObservation = true;
            }
        }

        if ($hasFailure) {
            $checklistResult = 'NO_APTO';
        } elseif ($hasObservation) {
            $checklistResult = 'APTO_CON_OBSERVACIONES';
        } else {
            $checklistResult = 'APTO';
        }
    // =====================================================
    // DEFINIR ESTADO DEL VIAJE SEGÚN RESULTADO DEL CHECKLIST
    // =====================================================

    $tripStatus = $checklistResult === 'NO_APTO'
        ? 'NO_AUTORIZADO'
        : 'EN_USO';


        // =====================================================
        // 11. CREAR SALIDA + CHECKLIST
        // =====================================================

        $storedPhotos = [];

        try {

            $trip = DB::transaction(function () use (
                $validated,
                $passengers,
                $checklistCatalog,
                $checklistResult,
                $tripStatus,
                $request,
                &$storedPhotos
            ) {

                // ---------------------------------------------
                // Crear viaje
                // ---------------------------------------------

                $trip = VehicleTrip::create([
                    'vehicle_id' =>
                        $validated['vehicle_id'],

                    'driver_id' =>
                        $validated['driver_id'],

                    'registered_by_employee_id' =>
                        $validated['registered_by_employee_id'],

                    'departure_at' =>
                        $validated['departure_at'],

                    'departure_mileage' =>
                        $validated['departure_mileage'],

                    'departure_fuel' =>
                        $validated['departure_fuel'],

                    'destination' =>
                        $validated['destination'],

                    'project_id' =>
                        $validated['project_id'] ?? null,

                    'status' => $tripStatus,
                ]);

                // ---------------------------------------------
                // Acompañantes
                // ---------------------------------------------

                foreach ($passengers as $employeeId) {
                    $trip->passengers()->create([
                        'employee_id' => $employeeId,
                    ]);
                }

                // ---------------------------------------------
                // Cabecera del checklist
                // ---------------------------------------------

                $checklist = $trip->checklist()->create([
                    'result' => $checklistResult,
                    'inspected_at' => $validated['departure_at'],
                ]);

                // ---------------------------------------------
                // 25 respuestas
                // ---------------------------------------------

                foreach ($checklistCatalog as $catalogItem) {

                    $itemId = $catalogItem->id;

                    $checklistItem =
                        $checklist->items()->create([
                            'catalog_id' => $itemId,

                            'response' =>
                                $validated['checklist'][$itemId]['response'],

                            'observation' =>
                                $validated['checklist'][$itemId]['observation']
                                ?? null,
                        ]);

                    // -----------------------------------------
                    // Fotografías del punto
                    // -----------------------------------------

                    $photos = $request->file(
                        "checklist.{$itemId}.photos",
                        []
                    );

                    foreach ($photos as $photo) {

                        $path = $photo->store(
                            "vehicle-checklists/{$trip->id}/{$itemId}",
                            'public'
                        );

                        $storedPhotos[] = $path;

                        $checklistItem->photos()->create([
                            'path' => $path,
                            'original_name' =>
                                $photo->getClientOriginalName(),

                            'mime_type' =>
                                $photo->getMimeType(),

                            'size' =>
                                $photo->getSize(),
                        ]);
                    }
                }

                return $trip;
            });

        } catch (\Throwable $e) {

            /*
            * Los archivos del disco no forman parte de la
            * transacción SQL. Si algo falla después de guardar
            * una foto, eliminamos las fotos que alcanzaron a
            * almacenarse para no dejar archivos huérfanos.
            */
            foreach ($storedPhotos as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        // =====================================================
        // 12. RESPUESTA SEGÚN RESULTADO DEL CHECKLIST
        // =====================================================

        if ($checklistResult === 'NO_APTO') {

            $message =
                'Vehículo NO APTO. La inspección fue registrada, '
                . 'pero la salida NO fue autorizada.';

            if ($request->boolean('operational')) {
                return redirect()
                    ->route('vehicle-trips.operational.index')
                    ->with('error', $message);
            }

            return redirect()
                ->route('vehicle-trips.index')
                ->with('error', $message);
        }

        $message = $checklistResult === 'APTO_CON_OBSERVACIONES'
            ? 'Salida autorizada con observaciones. Checklist registrado correctamente.'
            : 'Salida autorizada. Checklist registrado correctamente.';

        if ($request->boolean('operational')) {
            return redirect()
                ->route('vehicle-trips.operational.index')
                ->with('success', $message);
        }

        return redirect()
            ->route('vehicle-trips.index')
            ->with('success', $message);
            
    }

    /**
     * Mostrar formulario para registrar el retorno de un vehículo.
     */
    public function createReturn(VehicleTrip $trip)
    {
        // Solo se puede retornar un viaje que esté actualmente en uso.
        if ($trip->status !== 'EN_USO') {
            abort(404);
        }

        $trip->load([
            'vehicle',
            'driver',
            'passengers.employee',
        ]);

        // Empleados activos que pueden registrar el retorno.
        $employees = Employee::where('active', true)
            ->orderBy('name')
            ->get();

        return view('vehicle_trips.return', compact(
            'trip',
            'employees'
        ));
    }

    /**
     * Registrar el retorno de un vehículo.
     */
    public function storeReturn(Request $request, VehicleTrip $trip)
    {
        // =====================================================
        // 1. VALIDAR QUE EL VIAJE ESTÉ ACTIVO
        // =====================================================

        if ($trip->status !== 'EN_USO') {
            throw ValidationException::withMessages([
                'trip' =>
                    'Este viaje ya fue retornado o no se encuentra activo.',
            ]);
        }

        // =====================================================
        // 2. VALIDAR DATOS DEL RETORNO
        // =====================================================

        $validated = $request->validate([
            'return_at' => [
                'required',
                'date',
                'after_or_equal:' . $trip->departure_at->format('Y-m-d H:i:s'),
            ],

            'return_mileage' => [
                'required',
                'integer',
                'min:' . $trip->departure_mileage,
            ],

            'return_fuel' => [
                'required',
                'in:1/4,1/2,3/4,Lleno',
            ],

            'return_observations' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'returned_by_employee_id' => [
                'required',
                'exists:employees,id',
            ],
        ]);

        // =====================================================
        // 3. REGISTRAR RETORNO
        // =====================================================

        DB::transaction(function () use ($trip, $validated) {

            $trip->update([
                'return_at' =>
                    $validated['return_at'],

                'return_mileage' =>
                    $validated['return_mileage'],

                'return_fuel' =>
                    $validated['return_fuel'],

                'return_observations' =>
                    $validated['return_observations'] ?? null,

                'returned_by_employee_id' =>
                    $validated['returned_by_employee_id'],

                'status' => 'RETORNADO',
            ]);
        });

        // =====================================================
        // 4. RESPUESTA
        // =====================================================

        $message = 'Retorno registrado correctamente.';

        if ($request->boolean('operational')) {
            return redirect()
                ->route('vehicle-trips.operational.index')
                ->with('success', $message);
        }

        return redirect()
            ->route('vehicle-trips.index')
            ->with('success', $message);
    }

    public function operationalIndex()
    {
        $trips = VehicleTrip::with([
                'vehicle',
                'driver',
                'registeredByEmployee',
            ])
            ->whereIn('status', ['EN_USO'])
            ->orderByDesc('departure_at')
            ->get();

        return view('vehicle_trips.operational.index', compact('trips'));
    }

    public function createOperationalDeparture()
    {
        $vehicles = Vehiculo::whereDoesntHave('trips', function ($query) {
                $query->where('status', 'EN_USO');
            })
            ->orderBy('numero_interno')
            ->get();

        $drivers = Employee::where('active', true)
            ->whereHas('licenses', function ($query) {
                $query->whereDate('expires_at', '>=', now()->toDateString());
            })
            ->orderBy('name')
            ->get();

        $employees = Employee::where('active', true)
            ->orderBy('name')
            ->get();

        $checklistItems = VehicleChecklistCatalog::where('active', true)
            ->orderBy('sort_order')
            ->get();

        return view('vehicle_trips.create', [
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'employees' => $employees,
            'checklistItems' => $checklistItems,
            'operational' => true,
        ]);
    }

    public function createOperationalReturn(VehicleTrip $trip)
    {
        if ($trip->status !== 'EN_USO') {
            abort(404);
        }

        $trip->load([
            'vehicle',
            'driver',
            'passengers.employee',
        ]);

        $employees = Employee::where('active', true)
            ->orderBy('name')
            ->get();

        return view('vehicle_trips.return', [
            'trip' => $trip,
            'employees' => $employees,
            'operational' => true,
        ]);
    }


    public function storeOperationalReturn(Request $request, VehicleTrip $trip)
    {
        // Indicamos al método existente que el retorno
        // proviene del módulo operacional.
        $request->merge([
            'operational' => true,
        ]);

        return $this->storeReturn($request, $trip);
    }
}
