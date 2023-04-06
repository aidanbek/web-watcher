<?php

namespace Ditcher;

use App\Models\Resource;
use Illuminate\Support\Collection;

class PageService
{
    /**
     * @param VisitedPage $visitedPage
     * @param $parent
     */
    public function createResourcesFromVisitedPage(VisitedPage $visitedPage, $parent = null): void
    {
        $resource = new Resource();
        $resource->url = $visitedPage->getUrl();
        $resource->parent_id = $parent;
        $resource->save();
        $resource->dumps()->create(
            [
                'html'        => $visitedPage->getHtml(),
                'pretty_html' => $visitedPage->getPrettyHtml(),
                'hash'        => $visitedPage->getHash()
            ]
        );

        foreach ($visitedPage->getChildren() as $child) {
            $this->createResourcesFromVisitedPage($child, $resource->id);
        }
    }
}