<?php

namespace App\Exports;

use App\Repositories\Contracts\TypeTableRepositoryInterface;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Exception;

class TypeTableExport implements FromView
{
    protected TypeTableRepositoryInterface $typeTableRepository;
    protected string $format;
    protected array $filters;
    protected array $columns;
    public function __construct(string $format, array $filters, array $columns)
    {
        $this->typeTableRepository = app(TypeTableRepositoryInterface::class);
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
        $typeTables = $this->typeTableRepository->all($this->filters);
        return view('exports.type_table', ['columns' => $this->columns,'type_tables' => $typeTables]);
    }
}
