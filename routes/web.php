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
    $pages = (new \Ditcher\Test())->test();
    dd(
        parse_url(collect($pages)->map->href[0])
    );
    $indenter = new \Gajus\Dindent\Indenter();

//    $clean = preg_replace('/\s+/', '', $pages[0]['html']);

//    dd(
//        Hash::make($clean),
//        Hash::make($pages[0]['html'])
//    );

//    echo $indenter->indent($pages[0]['html']);

//    return;
    $diff = (new \Ditcher\PlainTextDiffCalculator())->calculate(
        $indenter->indent($pages[0]['html']),
        $indenter->indent('<br>'.$pages[0]['html'].'<br>')
    );

    echo    $diff;
});
