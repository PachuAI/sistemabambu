<div>
    <h1>Lista de Productos</h1>

    <table border="1" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>SKU</th>
                <th>Precio Base</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->sku }}</td>
                    <td>${{ $producto->precio_base_l1 }}</td>
                    <td>{{ $producto->stock_actual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>