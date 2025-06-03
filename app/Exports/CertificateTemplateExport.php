<?php

namespace App\Exports;

use App\Models\Assistance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CertificateTemplateExport implements FromView, ShouldAutoSize, WithStyles
{

    public $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $assistances = Assistance::where('event_id', $this->eventId)->get();
        return view('utils.reports.certificate-template-report', ['assistances' => $assistances]);
    }

    public function styles(Worksheet $sheet)
    {
        // Determine the last column based on the number of headers
        $highestColumn = $sheet->getHighestColumn();
        $headerRange = 'A1:' . $highestColumn . '1';

        // Apply styles to the header row
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Apply borders and alignment for all rows
        $sheet->getStyle('A1:' . $highestColumn . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Adjust column widths for better readability
        foreach (range('A', $highestColumn) as $column) {

            // Add vertical padding to the cells
            $sheet->getStyle($column . '1:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle($column . '1:' . $column . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        }
    }
}
