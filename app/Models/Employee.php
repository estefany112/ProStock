<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\EmployeeLicense;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'codigo_personal',
        'dpi',
        'position',
        'salary_base',
        'fecha_ingreso',
        'fecha_baja',
        'active',
        'isr',
        'status',
    ];

    /**
     * Generar automáticamente el código personal
     * cuando se crea un empleado nuevo.
     */
protected static function booted(): void
{
    static::created(function ($employee) {
        $employee->codigo_personal = self::generarCodigoPersonal($employee);

        $employee->saveQuietly();
    });

    static::updating(function ($employee) {
        if (
            $employee->isDirty('name') ||
            $employee->isDirty('dpi')
        ) {
            $employee->codigo_personal = self::generarCodigoPersonal($employee);
        }
    });
}

    /**
     * Genera un código personal único.
     *
     * Formato:
     * INICIALES-ÚLTIMOS4DPI
     *
     * Ejemplo:
     * Javier Linares + DPI terminado en 0102
     * JL-0102
     */
    public static function generarCodigoPersonal($employee): string
    {
        // =====================================================
        // 1. OBTENER INICIALES DEL NOMBRE
        // =====================================================

        $nombre = trim($employee->name ?? '');

        $palabras = preg_split('/\s+/', $nombre);

        $iniciales = '';

        foreach ($palabras as $palabra) {

            if ($palabra !== '') {
                $iniciales .= strtoupper(
                    mb_substr($palabra, 0, 1)
                );
            }
        }

        // Máximo 4 iniciales
        $iniciales = mb_substr($iniciales, 0, 4);

        // Si por alguna razón no hay nombre
        if (empty($iniciales)) {
            $iniciales = 'EMP';
        }

        // =====================================================
        // 2. LIMPIAR DPI
        // =====================================================

        $dpi = preg_replace(
            '/\D/',
            '',
            $employee->dpi ?? ''
        );

        // =====================================================
        // 3. OBTENER ÚLTIMOS 4 DÍGITOS DEL DPI
        // =====================================================

        $ultimosDpi = substr($dpi, -4);

        // Si no hay suficientes dígitos en el DPI,
        // usamos el ID del empleado.
        if (strlen($ultimosDpi) < 4) {

            $ultimosDpi = str_pad(
                $employee->id,
                4,
                '0',
                STR_PAD_LEFT
            );
        }

        // =====================================================
        // 4. CREAR CÓDIGO BASE
        // =====================================================

        $codigoBase = $iniciales . '-' . $ultimosDpi;

        $codigo = $codigoBase;

        // =====================================================
        // 5. ASEGURAR QUE SEA ÚNICO
        // =====================================================

        $contador = 1;

        while (
            self::where('codigo_personal', $codigo)
                ->where('id', '!=', $employee->id)
                ->exists()
        ) {
            $codigo = $codigoBase . '-' . $contador;

            $contador++;
        }

        return $codigo;
    }

    public function planillas()
    {
        return $this->belongsToMany(
            Planilla::class,
            'planilla_detalles'
        )
        ->withPivot(
            'salary_base_quincenal',
            'bonificacion',
            'igss',
            'isr',
            'otros_descuentos',
            'liquido_recibir'
        )
        ->withTimestamps();
    }

    public function scopeActivosEnRango($query, $inicio, $fin)
    {
        return $query->where('fecha_ingreso', '<=', $fin)
            ->where(function ($q) use ($inicio) {
                $q->whereNull('fecha_baja')
                    ->orWhere('fecha_baja', '>=', $inicio);
            });
    }

    public function salaryHistories()
    {
        return $this->hasMany(SalaryHistory::class);
    }

    public function movements()
    {
        return $this->hasMany(EmployeeMovement::class);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(EmployeeLicense::class);
    }

    /**
     * Viajes en los que el empleado fue conductor.
     */
    public function tripsAsDriver(): HasMany
    {
        return $this->hasMany(
            VehicleTrip::class,
            'driver_id'
        );
    }

    /**
     * Viajes que fueron registrados por este empleado.
     */
    public function tripsRegistered(): HasMany
    {
        return $this->hasMany(
            VehicleTrip::class,
            'registered_by_employee_id'
        );
    }

}