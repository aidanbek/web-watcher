<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::parents()
            ->with('lastDump')
            ->withCount('children')
            ->orderBy('title')
            ->get();

        return Inertia::render('Pages/Index', ['pages' => $pages,]);
    }

    public function show($id)
    {
        $page = Page::query()
            ->with(['children' => function ($q) {
                $q
                    ->withCount('children')
                    ->with('lastDump');
            }])
            ->with('lastDump')
            ->findOrFail($id);

        return Inertia::render('Pages/Show', ['page' => $page,]);
    }
}
