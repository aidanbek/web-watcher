<?php

namespace Ditcher;

use Gajus\Dindent\Exception\RuntimeException;
use Gajus\Dindent\Indenter;
use Goutte\Client;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;
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
    public function visit(string $url): VisitedPage
    {
        $children = new Collection();

        $page = $this->client->request('GET', $url);

        $childrenLinks = new Collection(
            $page
                ->filter($this->getFilterSelector($url))
                ->each(fn($n) => $n)
        );

        $shouldVisit = new Collection();

        $childrenLinks->map(function (Crawler $link) use ($url, $children, $shouldVisit) {
            if (!$children->has(UriResolver::resolve($link->attr('href'), $url))) {
                $shouldVisit->add($link);
            }
        });

        $shouldVisit->map(function (Crawler $link) use (&$children, $url) {
            $children->add(
                $this->visit(UriResolver::resolve($link->attr('href'), $url))
            );
        });

        $html = $page->html();
        $clean = preg_replace('/\s+/', '', $html);

        return new VisitedPage(
            url       : $url,
            html      : $html,
            prettyHtml: $this->indenter->indent($html),
            hash      : $this->hashManager->make($clean),
            children  : $children
        );
    }
}