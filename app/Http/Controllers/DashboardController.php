<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function datosDashboard() {
        $data['regional'] = [
            ['nombre' => 'Santa Cruz', 'valor' => 20],
            ['nombre' => 'Cochabamba', 'valor' => 55],
            ['nombre' => 'La Paz', 'valor' => 78],
            ['nombre' => 'Beni', 'valor' => 123]
        ];

        $data['canal'] = [
            ['nombre' => 'Directo', 'valor' => 20],
            ['nombre' => 'Formal', 'valor' => 55],
            ['nombre' => 'Horizontal', 'valor' => 78]
        ];

        $data['visitas'] = [
            ['fecha' => '2024-09-01', 'metas' => 20, 'visitas' => 37],
            ['fecha' => '2024-09-02', 'metas' => 55, 'visitas' => 33],
            ['fecha' => '2024-09-03', 'metas' => 78, 'visitas' => 58],
            ['fecha' => '2024-09-04', 'metas' => 18, 'visitas' => 73],
            ['fecha' => '2024-09-05', 'metas' => 67, 'visitas' => 120],
            ['fecha' => '2024-09-06', 'metas' => 90, 'visitas' => 128],
            ['fecha' => '2024-09-06', 'metas' => 112, 'visitas' => 120]
        ];

        return $data;
    }
}
