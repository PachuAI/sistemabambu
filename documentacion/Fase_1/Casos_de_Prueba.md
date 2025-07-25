# Fase 1: Casos de Prueba - CRUD de Productos

## Resumen de Pruebas

Esta tabla resume los escenarios que se prueban en el código de abajo.


| Caso                               | Objetivo                                                                                   |
| ---------------------------------- | ------------------------------------------------------------------------------------------ |
| **crea un producto exitosamente**  | Garantiza que la ruta `store` valide, persista y devuelva 201.                             |
| **falla si el SKU ya existe**      | Comprueba unicidad (`unique:productos,sku`).                                               |
| **falla si el precio es negativo** | Verifica regla `min:0.01`.                                                                 |
| **actualiza correctamente**        | Confirma que `update` modifica los campos y persiste en DB.                                |
| **soft delete**                    | Asegura que `destroy` marque `deleted_at` sin eliminar físicamente (Eloquent SoftDeletes). |


## Código de Implementación (`ProductoTest.php`)


```php
<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

/* ---------------------------------
 | Creación
 * --------------------------------*/

it('crea un producto exitosamente', function () {
    $payload = [
        'nombre'           => 'Lavandina 5 L',
        'sku'              => 'BAM-001',
        'precio_base_l1'   => 1200.50,
        'stock_actual'     => 100,
    ];

    $response = $this->postJson(route('productos.store'), $payload);

    $response->assertCreated()
             ->assertJsonFragment(['sku' => 'BAM-001']);

    $this->assertDatabaseHas('productos', [
        'sku'        => 'BAM-001',
        'deleted_at' => null,
    ]);
});

/* ---------------------------------
 | Validaciones
 * --------------------------------*/

it('falla al crear si el SKU ya existe', function () {
    Product::factory()->create(['sku' => 'DUP-123']);

    $payload = Product::factory()->make(['sku' => 'DUP-123'])->toArray();

    $this->postJson(route('productos.store'), $payload)
         ->assertStatus(422)
         ->assertJsonValidationErrors('sku');
});

it('falla al crear si el precio es negativo', function () {
    $payload = Product::factory()->make([
        'precio_base_l1' => -10,
    ])->toArray();

    $this->postJson(route('productos.store'), $payload)
         ->assertStatus(422)
         ->assertJsonValidationErrors('precio_base_l1');
});

/* ---------------------------------
 | Actualización
 * --------------------------------*/

it('actualiza un producto correctamente', function () {
    $product = Product::factory()->create([
        'nombre' => 'Detergente 1 L',
        'sku'    => 'DET-001',
    ]);

    $payload = ['nombre' => 'Detergente concentrado 1 L'];

    $this->patchJson(route('productos.update', $product), $payload)
         ->assertOk()
         ->assertJsonFragment($payload);

    $this->assertDatabaseHas('productos', [
        'id'     => $product->id,
        'nombre' => 'Detergente concentrado 1 L',
    ]);
});

/* ---------------------------------
 | Baja lógica (soft delete)
 * --------------------------------*/

it('realiza soft delete de un producto', function () {
    $product = Product::factory()->create();

    $this->deleteJson(route('productos.destroy', $product))
         ->assertNoContent();

    $this->assertSoftDeleted('productos', [
        'id' => $product->id,
    ]);
});

?> 