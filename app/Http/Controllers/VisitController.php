<?php

namespace App\Http\Controllers;

use Ditcher\PageService;
use Ditcher\Visitor;

class VisitController extends Controller
{
    public function __construct(
        private readonly Visitor     $visitor,
        private readonly PageService $pageService
    )
    {
    }

    public function test()
    {
        $url = 'https://epayment.kz/ru/docs';

        $visitedPages = $this->visitor->visitRecursively($url);
        $this->pageService->createPageTree($visitedPages);;

        dd('success');
    }
}
