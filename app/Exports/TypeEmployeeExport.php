<?php

namespace App\Exports;

use App\Models\TypeEmployee;
use App\Repositories\TypeEmployee\TypeEmployeeRepository;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Exception;

class TypeEmployeeExport implements FromView
{
    protected TypeEmployeeRepository $typeEmployeeRepository;
    protected string $format;
    protected array $filters;
    protected array $columns;
    public function __construct(string $format, array $filters, array $columns)
    {
        $this->typeEmployeeRepository = app(TypeEmployeeRepository::class);
        $this->format = $format;
        $this->filters = $filters;
        $this->columns = $columns;
    }

    /**
     * @return View
     * @throws Exception
     */
    public function view(): View
    {
        $typeEmployees = $this->typeEmployeeRepository->all($this->filters);
        return view('exports.type_employees', ['columns' => $this->columns,'type_employees' => $typeEmployees]);
    }
}
