<?php

namespace Ditcher;

final class VisitedPageCollection
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

    public function has($key): bool
    {
        return isset($this->items[$key]);
    }

    public function put($key, VisitedPage $page): void
    {
        $this->items[$key] = $page;
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
