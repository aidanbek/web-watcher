<?php

namespace Ditcher;

use Illuminate\Support\Collection;

class VisitedPage
{
    public function __construct(
        private readonly string     $url,
        private readonly string     $html,
        private readonly string     $prettyHtml,
        private readonly string     $hash,
        private readonly Collection $children
    )
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @return Collection<string, VisitedPage>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @return string
     */
    public function getPrettyHtml(): string
    {
        return $this->prettyHtml;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}