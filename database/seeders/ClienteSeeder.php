<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan.perez@email.com',
                'telefono' => '+1-234-567-8901',
                'direccion' => 'Av. Principal 123, Ciudad'
            ],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'email' => 'maria.gonzalez@email.com',
                'telefono' => '+1-234-567-8902',
                'direccion' => 'Calle Secundaria 456, Ciudad'
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'email' => 'carlos.rodriguez@email.com',
                'telefono' => '+1-234-567-8903',
                'direccion' => 'Plaza Central 789, Ciudad'
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'López',
                'email' => 'ana.lopez@email.com',
                'telefono' => '+1-234-567-8904',
                'direccion' => 'Boulevard Norte 101, Ciudad'
            ],
            [
                'nombre' => 'Pedro',
                'apellido' => 'Martínez',
                'email' => 'pedro.martinez@email.com',
                'telefono' => null,
                'direccion' => 'Avenida Sur 202, Ciudad'
            ]
        ];

        foreach ($clientes as $clienteData) {
            Cliente::create($clienteData);
        }
    }
}
