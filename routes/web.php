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
    $pages = (new \Ditcher\HttpContentExtractor())->extract();


    $indenter = new \Gajus\Dindent\Indenter();


    $pages = $indenter->indent($pages);

    $diff = (new \Ditcher\StringDiffCalculator())->calculate(
        old: $pages,
        new: $pages
    );

    dd($diff);

});
