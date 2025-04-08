<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;

class ReportsExport implements FromView
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
        return view('utils.reports.assistance-report', [
            'ReportCollection' => $this->ReportCollection,
            'ReportType' => $this->ReportType,
            'IsColombian' => $this->IsColombian,
        ]);
    }
}
