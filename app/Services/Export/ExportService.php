<?php

namespace App\Services\Export;

use App\Factories\ExportFactory;
use App\Strategys\ExportStrategies\PdfExportStrategy;
use App\Strategys\ExportStrategies\XlsxExportStrategy;
use Exception;
class ExportService
{
    /**
     * @throws Exception
     */
    public function exportBase64(string $export, string $format, array $filters, array $columns): array
    {
        $exportInstance = ExportFactory::make($export, $format, $filters, $columns);
        $strategy = match ($format)
        {
            'xlsx' => new XlsxExportStrategy(),
            'pdf' => new PdfExportStrategy(),
            default => throw new Exception("Export {$format} no implementado"),
        };
        return [
            'file' => $strategy->export($exportInstance),
            'mime' => $strategy->getMimeType(),
        ];
    }
}
