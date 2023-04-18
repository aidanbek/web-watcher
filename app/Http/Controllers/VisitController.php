<?php

namespace App\Http\Controllers;

use App\Models\PageDump;
use Ditcher\PageDumpService;
use Ditcher\PageService;
use Ditcher\Visitor;
use Gajus\Dindent\Exception\RuntimeException;

class VisitController extends Controller
{
    public function __construct(
        private readonly Visitor     $visitor,
        private readonly PageService $pageService,
        private readonly PageDumpService $dumpService
    )
    {
    }

    /**
     * @throws RuntimeException
     */
    public function test()
    {
        $url = 'https://epayment.kz/ru/docs';
//        $url = 'https://nuxtjs.org/docs';

        $visitedPages = $this->visitor->visitNested($url);
        $pages = $this->pageService->createPageTree($visitedPages);
        $dumps = $this->dumpService->dumpPageCollection($visitedPages);

        dd($dumps);
    }
}
