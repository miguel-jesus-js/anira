<?php

namespace App\Strategys\ExportStrategies;

use App\Interfaces\Export\ExportInterface;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;

class PdfExportStrategy implements ExportInterface
{
    public function export(FromView $fromView): string
    {
        return base64_encode(Excel::raw($fromView, \Maatwebsite\Excel\Excel::DOMPDF));
    }
    public function getMimeType(): string
    {
        return 'application/pdf';
    }
}
