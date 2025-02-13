<?php

namespace App\Strategys\ExportStrategies;

use App\Interfaces\Export\ExportInterface;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;


class XlsxExportStrategy implements ExportInterface
{
    public function export(FromView $fromView): string
    {
        return base64_encode(Excel::raw($fromView, \Maatwebsite\Excel\Excel::XLSX));
    }
    public function getMimeType(): string
    {
        return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    }
}
