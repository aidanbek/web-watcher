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

    public function add(VisitedPage $page): void
    {
        $this->items[] = $page;
    }

    public function merge(VisitedPageCollection $collection): VisitedPageCollection
    {
        return new VisitedPageCollection(...$this->items, ...$collection->all());
    }

    public function all(): array
    {
        return $this->items;
    }
}