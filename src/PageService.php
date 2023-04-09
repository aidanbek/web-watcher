<?php

namespace Ditcher;

use App\Models\Page;

class PageService
{
    /**
     * @param string $url
     * @return Page
     */
    public function firstOrCreate(string $url): Page
    {
        return Page::firstOrCreate(['url' => $url]);
    }

    public function createPageTree(VisitedPageCollection $visitedPages): array
    {
        $pages = [];

        foreach ($visitedPages->all() as $visitedPage) {
            $pages[$visitedPage->getUrl()] = $this->firstOrCreate($visitedPage->getUrl());
        }

        foreach ($visitedPages->all() as $visitedPage) {
            if ($visitedPage->getParentUrl()) {
                $page = $pages[$visitedPage->getUrl()];
                $page->parent_id = $pages[$visitedPage->getParentUrl()]->id;
                $page->save();
            }
        }

        return $pages;
    }
}