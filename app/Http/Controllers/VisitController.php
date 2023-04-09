<?php

namespace App\Http\Controllers;

use Ditcher\PageService;
use Ditcher\Visitor;
use Gajus\Dindent\Exception\RuntimeException;

class VisitController extends Controller
{
    public function __construct(
        private readonly Visitor     $visitor,
        private readonly PageService $pageService
    )
    {
    }

    /**
     * @throws RuntimeException
     */
    public function test()
    {
        $url = 'https://epayment.kz/ru/docs';

        $visitedPages = $this->visitor->visitNested($url);
        $pages = $this->pageService->createPageTree($visitedPages);

        dd($pages);
    }
}
