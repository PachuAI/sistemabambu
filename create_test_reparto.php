<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Pedido;
use App\Models\Vehiculo;
use App\Models\Reparto;

$pedido = Pedido::where('estado', 'confirmado')->first();
$vehiculo = Vehiculo::first();

if ($pedido && $vehiculo) {
    Reparto::create([
        'fecha_reparto' => now()->format('Y-m-d'),
        'vehiculo_id' => $vehiculo->id,
        'pedido_id' => $pedido->id,
        'bultos_asignados' => 10,
        'orden_entrega' => 1,
        'estado' => 'planificado'
    ]);
    
    echo "Reparto creado exitosamente\n";
    echo "Total repartos: " . Reparto::count() . "\n";
} else {
    echo "No hay datos disponibles\n";
}