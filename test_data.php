<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo 'Vehiculos: ' . App\Models\Vehiculo::count() . PHP_EOL;
echo 'Repartos: ' . App\Models\Reparto::count() . PHP_EOL;
echo 'Fecha hoy: ' . now()->format('Y-m-d') . PHP_EOL;
echo 'Repartos hoy: ' . App\Models\Reparto::where('fecha_reparto', now()->format('Y-m-d'))->count() . PHP_EOL;

$repartos = App\Models\Reparto::with(['pedido.cliente.ciudad', 'vehiculo'])->get();
echo 'Repartos con relaciones: ' . $repartos->count() . PHP_EOL;

foreach ($repartos as $reparto) {
    echo "- Reparto {$reparto->id}: {$reparto->pedido->cliente->nombre} -> {$reparto->vehiculo->nombre}" . PHP_EOL;
}