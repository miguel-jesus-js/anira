<?php

namespace App\Factories;

use App\Exports\CustomerExport;
use App\Exports\EmployeesExport;
use App\Exports\TypeCustomerExport;
use App\Exports\TypeEmployeeExport;
use App\Interfaces\Export\ExportInterface;
use Exception;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportFactory
{
    /**
     * Método que define el export a usar
     *
     * @param string $model modelo a exportar
     * @param array $filters Filtros aplicados a los datos
     * @param array $columns Columnas que deben ser exportadas
     *
     * @throws Exception
     */
    public static function make(string $model, string $format, array $filters, array $columns): TypeEmployeeExport|EmployeesExport|TypeCustomerExport|CustomerExport
    {
        return match ($model) {
            'employees' => new EmployeesExport($format, $filters, $columns),
            'customers' => new CustomerExport($format, $filters, $columns),
            'type_employees' => new TypeEmployeeExport($format, $filters, $columns),
            'type_customers' => new TypeCustomerExport($format, $filters, $columns),
            default => throw new Exception("Export {$model} no implementado"),
        };
    }
}
