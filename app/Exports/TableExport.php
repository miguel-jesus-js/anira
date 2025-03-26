<?php

namespace App\Exports;

use App\Repositories\Contracts\TableRepositoryInterface;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Exception;

class TableExport implements FromView
{
    protected TableRepositoryInterface $tableRepository;
    protected string $format;
    protected array $filters;
    protected array $columns;
    public function __construct(string $format, array $filters, array $columns)
    {
        $this->tableRepository = app(TableRepositoryInterface::class);
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
        $tables = $this->tableRepository->all($this->filters, ['typeTable']);
        return view('exports.tables', ['columns' => $this->columns, 'tables' => $tables]);
    }
}
