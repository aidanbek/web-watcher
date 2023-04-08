<?php

namespace Ditcher;

use Gajus\Dindent\Exception\RuntimeException;
use Gajus\Dindent\Indenter;
use Goutte\Client;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\UriResolver;

class Visitor
{
    public function __construct(
        private readonly Client      $client,
        private readonly HashManager $hashManager,
        private readonly Indenter    $indenter
    )
    {
    }

    private function getFilterSelector(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        return 'a[href^="' . $path . '"]:not([href="' . $path . '"]),a[href^="' . $url . '"]:not([href="' . $url . '"])';
    }

    /**
     * @throws RuntimeException
     */
    public function visit(string $url, ?string $parentUrl = null): VisitedPage
    {
        $page = $this->client->request('GET', $url);

        $childrenLinks = new Collection(
            $page
                ->filter($this->getFilterSelector($url))
                ->each(fn($link) => UriResolver::resolve($link->attr('href'), $url))
        );

        $html = $page->html();
        $clean = preg_replace('/\s+/', '', $html);

        return new VisitedPage(
            url          : $url,
            html         : $html,
            prettyHtml   : $this->indenter->indent($html),
            hash         : $this->hashManager->make($clean),
            parentUrl    : $parentUrl,
            childrenLinks: $childrenLinks->filter(fn($link) => $link !== $url)
        );
    }

    public function visitRecursively(string $url): VisitedPageCollection
    {
        $accumulator = [];
        $visited = $this->visit($url);
        $accumulator[] = $visited;

        foreach ($visited->getChildrenLinks() as $childrenLink) {
            $accumulator[] = $this->visit($childrenLink, $url);
        }

        return new VisitedPageCollection(...$accumulator);
    }
}