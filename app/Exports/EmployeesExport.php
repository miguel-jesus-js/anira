<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeesExport implements FromView
{
    protected string $format;
    protected array $filters;
    protected array $columns;

    public function __construct(string $format, array $filters, array $columns)
    {
        $this->format = $format;
        $this->filters = $filters;
        $this->columns = $columns;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $employees = Employee::with(['typeEmployee', 'people', 'people.user'])->get();
        return view('exports.employees', ['columns' => $this->columns,'employees' => $employees]);
    }
}
