<?php

namespace Ditcher;

use App\Models\Page;
use App\Models\PageDump;

class PageDumpService
{
    public function dumpPageCollection(VisitedPageCollection $pageCollection): array
    {
        $dumps = [];

        foreach ($pageCollection->all() as $page) {
            $dumps[] = $this->dumpPage($page);
        }

        return $dumps;
    }

    public function dumpPage(VisitedPage $page): PageDump
    {
        $dump              = new PageDump();
        $dump->page_id     = Page::where('url', $page->getUrl())->firstOrFail()->id;
        $dump->html        = htmlentities($page->getHtml());
        $dump->pretty_html = htmlentities($page->getPrettyHtml());
        $dump->hash        = $page->getHash();
        $dump->save();

        return $dump;
    }
}

