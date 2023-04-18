<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::parents()
            ->withCount('children')
            ->orderBy('url')
            ->get();

        return Inertia::render('Pages/Index', [
            'pages' => $pages,
        ]);
    }

    public function show($id)
    {
        $page = Page::withCount('children')->firstOrFail($id);

        return Inertia::render('Pages/Show', [
            'page' => $page,
        ]);
    }
}
