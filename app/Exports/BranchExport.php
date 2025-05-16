<?php

namespace App\Exports;

use App\Repositories\Contracts\BranchRepositoryInterface;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Exception;

class BranchExport implements FromView
{
    protected BranchRepositoryInterface $branchRepository;
    protected string $format;
    protected array $filters;
    protected array $columns;

    public function __construct(string $format, array $filters, array $columns)
    {
        $this->branchRepository = app(BranchRepositoryInterface::class);
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
        $branches = $this->branchRepository->all($this->filters, ['address']);
        return view('exports.branches', ['columns' => $this->columns,'branches' => $branches]);
    }
}
