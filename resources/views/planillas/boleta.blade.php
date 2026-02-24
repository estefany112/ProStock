<h2>BOLETA DE PAGO</h2>

<p>Empleado: {{ $empleado->name }}</p>
<p>DPI: {{ $empleado->dpi }}</p>
<p>Cargo: {{ $empleado->position }}</p>

<p>Periodo: {{ $planilla->fecha_inicio }} al {{ $planilla->fecha_fin }}</p>

<hr>

<p>Salario: Q {{ number_format($empleado->pivot->salary_base_quincenal,2) }}</p>
<p>Bonificación: Q {{ number_format($empleado->pivot->bonificacion,2) }}</p>
<p>IGSS: Q {{ number_format($empleado->pivot->igss,2) }}</p>
<p>ISR: Q {{ number_format($empleado->pivot->isr,2) }}</p>

<hr>

<h3>Líquido a recibir: Q {{ number_format($empleado->pivot->liquido_recibir,2) }}</h3>