<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerExport implements FromView
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
        $customers = Customer::with(['typeCustomer', 'people', 'people.user'])->get();
        return view('exports.customers', ['columns' => $this->columns,'customers' => $customers]);
    }
}
