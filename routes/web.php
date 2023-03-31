<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $client = new \Goutte\Client();

    $crawler = $client->request('GET', 'https://epayment.kz/docs');

    /** @var \Symfony\Component\DomCrawler\Crawler $menu */
    $menu = $crawler->filter('[class^="DocumentationSideNav_sideNav"]')->each(function ($node) {
        return $node;
    })[0];

//    dd($menu);

    $links = $menu->filter('ul a');

    $pages = [];
    $links
        ->each(function (/** @var \Symfony\Component\DomCrawler\Crawler $node */ $node) use (&$pages) {
        $customClient = new \Goutte\Client();

        $pages[$node->text()] = [
            'href' => $node->attr('href'),
            'html' => $customClient->click($node->link())->html()
        ];
    });


//    dd(
    $diffOptions = [
        // show how many neighbor lines
        // Differ::CONTEXT_ALL can be used to show the whole file
        'context'          => 1,
        // ignore case difference
        'ignoreCase'       => false,
        // ignore line ending difference
        'ignoreLineEnding' => false,
        // ignore whitespace difference
        'ignoreWhitespace' => false,
    ];

    $indenter = new \Gajus\Dindent\Indenter();


    $pages['Cancelling payment']['html'] = $indenter->indent($pages['Cancelling payment']['html']);


    $diff = \Jfcherng\Diff\DiffHelper::calculate(
        old            : $pages['Cancelling payment']['html'],
        new            : $pages['Cancelling payment']['html'],
        renderer       : 'SideBySide',
        differOptions  : $diffOptions,
        rendererOptions: [
            'cliColorization' => \Jfcherng\Diff\Renderer\RendererConstant::CLI_COLOR_AUTO,
            'detailLevel' => 'word'
        ]
    );

//    dd($diff);

    return view('welcome', ['data' => $diff]);


//    );
});
