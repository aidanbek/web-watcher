<?php

namespace Ditcher;

use Illuminate\Support\Collection;

final class VisitedPage
{
    public function __construct(
        private readonly string     $url,
        private readonly string     $title,
        private readonly string     $html,
        private readonly string     $prettyHtml,
        private readonly string     $hash,
        private readonly ?string    $parentUrl,
        private readonly Collection $childrenLinks
    )
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @return Collection<string>
     */
    public function getChildrenLinks(): Collection
    {
        return $this->childrenLinks;
    }

    public function getParentUrl(): ?string
    {
        return $this->parentUrl;
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
