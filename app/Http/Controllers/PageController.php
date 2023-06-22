<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageDump;
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

    public function dumps($id)
    {
        $page  = Page::findOrFail($id);
        $dumps = PageDump::where('page_id', $id)
            ->latest()
            ->paginate();

        return Inertia::render('Pages/Dumps/Index', [
            'dumps' => $dumps,
            'page'  => $page
        ]);
    }

    public function dump($id, $dumpId)
    {
        $dump = PageDump::findOrFail($dumpId);
        return Inertia::render('Pages/Dumps/Index', ['dump' => $dump]);
    }
}
