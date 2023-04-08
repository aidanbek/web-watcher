<?php

namespace Ditcher;

class VisitedPageCollection
{
    /**
     * @var VisitedPage[]
     */
    private array $items;

    public function __construct(
        VisitedPage ...$visitedPages
    )
    {
        $this->items = $visitedPages;
    }

    public function all(): array
    {
        return $this->items;
    }
}