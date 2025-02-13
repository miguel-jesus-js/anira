<?php

namespace App\Interfaces\Export;

use Maatwebsite\Excel\Concerns\FromView;

interface ExportInterface
{
    /**
     * Método que debe implementar cada estrategia de exportación, retorna el archivo.
     *
     * @param FromView $fromView Export a usar
     *
     * @return string El archivo exportado codificado en Base64
     */
    public function export(FromView $fromView) : string;

    /**
     * Método que debe implementar cada estrategia de exportación, retorna el mime.
     *
     * @return string El mime a usar
     */
    public function getMimeType() : string;
}
