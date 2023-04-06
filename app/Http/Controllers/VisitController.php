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

        $visitedPage = $this->visitor->visit($url);

        $resources = $this->pageService->createResourcesFromVisitedPage($visitedPage);
        dd(
            $resources
        );
    }
}
