<?php

namespace App\Exports;

use App\Repositories\TypeCustomer\TypeCustomerRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Exception;

class TypeCustomerExport implements fromView
{
    protected TypeCustomerRepository $typeCustomerRepository;
    protected string $format;
    protected array $filters;
    protected array $columns;

    public function __construct(string $format, array $filters, array $columns)
    {
        $this->typeCustomerRepository = app(TypeCustomerRepository::class);
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
        $typeCustomers = $this->typeCustomerRepository->all($this->filters);
        return view('exports.type_customers', ['columns' => $this->columns,'type_customers' => $typeCustomers]);
    }
}
