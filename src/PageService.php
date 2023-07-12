<?php

namespace Ditcher;

use App\Models\Page;

final class PageService
{
    public function createPageTree(VisitedPageCollection $visitedPages): array
    {
        $pages = [];

        foreach ($visitedPages->all() as $visitedPage) {
            $pages[$visitedPage->getUrl()] = $this->firstOrCreate(
                url  : $visitedPage->getUrl(),
                title: $visitedPage->getTitle()
            );
        }

        foreach ($visitedPages->all() as $visitedPage) {
            if ($visitedPage->getParentUrl()) {
                $page            = $pages[$visitedPage->getUrl()];
                $page->parent_id = $pages[$visitedPage->getParentUrl()]->id;
                $page->save();
            }
        }

        return $pages;
    }

    /**
     * @param string $url
     * @return Page
     */
    public function firstOrCreate(string $url, string $title): Page
    {
        return Page::firstOrCreate(
            ['url' => $url],
            ['title' => $title]
        );
    }
}
