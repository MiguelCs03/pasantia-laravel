<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = [
            [
                'nombre' => 'Coca-Cola 500ml',
                'descripcion' => 'Bebida gaseosa sabor cola en botella de 500ml',
                'precio' => 2.50,
                'stock' => 100,
                'codigo' => 'CC-500',
                'categoria' => 'Bebidas',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Pepsi 500ml',
                'descripcion' => 'Bebida gaseosa sabor cola en botella de 500ml',
                'precio' => 2.30,
                'stock' => 80,
                'codigo' => 'PP-500',
                'categoria' => 'Bebidas',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Agua Mineral 1L',
                'descripcion' => 'Agua mineral natural en botella de 1 litro',
                'precio' => 1.50,
                'stock' => 150,
                'codigo' => 'AM-1L',
                'categoria' => 'Bebidas',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Arroz Diana 1kg',
                'descripcion' => 'Arroz blanco de primera calidad de 1 kilogramo',
                'precio' => 3.20,
                'stock' => 50,
                'codigo' => 'AD-1KG',
                'categoria' => 'Granos',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Aceite Girasol 900ml',
                'descripcion' => 'Aceite de girasol refinado en botella de 900ml',
                'precio' => 4.80,
                'stock' => 40,
                'codigo' => 'AG-900',
                'categoria' => 'Aceites',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Pan Integral',
                'descripcion' => 'Pan integral tajado de 500 gramos',
                'precio' => 2.80,
                'stock' => 30,
                'codigo' => 'PI-500',
                'categoria' => 'Panadería',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Leche Entera 1L',
                'descripcion' => 'Leche entera pasteurizada en caja de 1 litro',
                'precio' => 2.90,
                'stock' => 60,
                'codigo' => 'LE-1L',
                'categoria' => 'Lácteos',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Yogurt Natural',
                'descripcion' => 'Yogurt natural cremoso de 150 gramos',
                'precio' => 1.80,
                'stock' => 45,
                'codigo' => 'YN-150',
                'categoria' => 'Lácteos',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Galletas Oreo',
                'descripcion' => 'Galletas con crema sabor vainilla paquete de 150g',
                'precio' => 1.95,
                'stock' => 70,
                'codigo' => 'GO-150',
                'categoria' => 'Snacks',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Detergente Ariel 500g',
                'descripcion' => 'Detergente en polvo para ropa de 500 gramos',
                'precio' => 3.50,
                'stock' => 25,
                'codigo' => 'DA-500',
                'categoria' => 'Limpieza',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Champú Sedal 400ml',
                'descripcion' => 'Champú nutritivo para cabello normal de 400ml',
                'precio' => 4.20,
                'stock' => 35,
                'codigo' => 'CS-400',
                'categoria' => 'Cuidado Personal',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Atún en Lata',
                'descripcion' => 'Atún en aceite vegetal lata de 170 gramos',
                'precio' => 2.40,
                'stock' => 90,
                'codigo' => 'AL-170',
                'categoria' => 'Conservas',
                'estado' => 'activo'
            ]
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
