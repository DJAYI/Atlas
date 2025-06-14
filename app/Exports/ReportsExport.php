<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $ReportCollection;
    public $ReportType;
    public $IsColombian;

    public function __construct($ReportCollection, $ReportType, $IsColombian)
    {
        $this->ReportCollection = $ReportCollection;
        $this->ReportType = $ReportType;
        $this->IsColombian = $IsColombian;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('utils.reports.snies-report', [
            'ReportCollection' => $this->ReportCollection,
            'ReportType' => $this->ReportType,
            'IsColombian' => $this->IsColombian,
        ]);
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
            $sheet->getColumnDimension($column)->setAutoSize(true);

            // Add vertical padding to the cells
            $sheet->getStyle($column . '1:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle($column . '1:' . $column . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        }
    }
}
