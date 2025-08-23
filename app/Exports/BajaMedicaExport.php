<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; 
use Maatwebsite\Excel\Concerns\WithStyles; 
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 

class BajaMedicaExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting{
    protected $arrayBajaMedica;

    public function __construct($request)
    {
        // Asegurarse de que el parámetro 'arrayBajaMedica' exista y sea un array
        $this->arrayBajaMedica = $request->arrayBajaMedica;
    }

    public function collection()
    {   
        $bajasMedicas = [];
        foreach ($this->arrayBajaMedica as $itemJson) {
            $item = json_decode($itemJson, true); 
        

        // Recorrer el array y extraer los datos
            $bajasMedicas[] = [
                $item['persona'],         // Nombre del personal (C100000 | Eloy Vaca Flores)
                $item['b_centro_medico'], // Centro médico
                $item['b_doctor'],        // Nombre del doctor
                $item['b_motivo'],        // Motivo
                date('d/m/Y H:i:s', strtotime($item['b_fechabaja'])), // Fecha baja con hora
                date('d/m/Y', strtotime($item['b_fechaini'])),       // Fecha inicio sin hora
                date('d/m/Y', strtotime($item['b_fechafin'])), 
            ];
        }

        return collect($bajasMedicas);
    }

    public function headings(): array
    {
        return [
            'Personal',
            'Centro Médico',
            'Doctor',
            'Motivo',
            'Fecha Baja',
            'Fecha Inicio',
            'Fecha Fin',
        ];
    }
    public function styles($sheet)
    {
        // Cambiar el color de fondo de los encabezados
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], 
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'], // Color verde para el fondo
            ]
        ]);

        // Ajustar el ancho de las columnas
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        return [
            // Puedes agregar más estilos si lo deseas
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => 'dd/mm/yyyy hh:mm:ss', // Fecha de baja
            'F' => 'dd/mm/yyyy', // Fecha de inicio
            'G' => 'dd/mm/yyyy', // Fecha de fin
        ];
    }

}