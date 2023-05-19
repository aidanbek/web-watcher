<?php

namespace App\Http\Controllers;

use Ditcher\PageDumpService;
use Ditcher\PageService;
use Ditcher\PlainTextDiffCalculator;
use Ditcher\Visitor;
use Gajus\Dindent\Exception\RuntimeException;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function __construct(
        private readonly Visitor                 $visitor,
        private readonly PageService             $pageService,
        private readonly PageDumpService         $dumpService,
        private readonly PlainTextDiffCalculator $calculator
    )
    {
    }

    /**
     * @throws RuntimeException
     */
    public function test()
    {
        $url = 'https://epayment.kz/ru/docs';

        DB::beginTransaction();
        try {
            $visitedPages = $this->visitor->visitNested($url);
            $pages = $this->pageService->createPageTree($visitedPages);
            $this->dumpService->dumpPageCollection($visitedPages);
            $this->calculator->calculateDiffForPagesDumps($pages);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }


    }
}
