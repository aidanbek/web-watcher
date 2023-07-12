<?php

namespace Ditcher;

use Gajus\Dindent\Exception\RuntimeException;
use Gajus\Dindent\Indenter;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\UriResolver;

final class Visitor
{
    private VisitedPageCollection $cache;

    public function __construct(
        private readonly Indenter $indenter,
        private readonly Factory  $client
    )
    {
    }

    /**
     * @throws RuntimeException
     */
    public function run(string $url): VisitedPageCollection
    {
        $this->emptyCache();


        $this->visitNested($url);

        $result = $this->getCache();

        $this->emptyCache();

        return $result;
    }

    private function emptyCache(): void
    {
        $this->cache = new VisitedPageCollection();
    }

    /**
     * @throws RuntimeException
     */
    private function visitNested(string $url, ?string $parentUrl = null): void
    {
        $decoded = urldecode($url);

        if ($this->getCache()->has($decoded)) {
            return;
        }

        Log::info($decoded . ' put to cache');
        $visited = $this->visit($url, $parentUrl);
        $this->getCache()->put($decoded, $visited);

        foreach ($visited->getChildrenLinks() as $link) {
            $this->visitNested($link, $url);
        }
    }

    private function getCache(): VisitedPageCollection
    {
        return $this->cache;
    }

    /**
     * @throws RuntimeException
     */
    private function visit(string $url, ?string $parentUrl = null): VisitedPage
    {
        $html = $this->client->get($url)->body();
        $page = new Crawler($html);

        $title = $page->filter('title')->count()
            ? $page->filter('title')->text()
            : '';

        $links = $this->getLinksFromPage($url, $page);

        return new VisitedPage(
            url          : $url,
            title        : $title,
            html         : $html,
            prettyHtml   : $this->indenter->indent($html),
            hash         : crc32($html),
            parentUrl    : $parentUrl,
            childrenLinks: $links,
        );
    }

    private function getLinksFromPage($url, Crawler $page): Collection
    {
        $childrenLinks = $page
            ->filter($this->getChildrenLinksSelector($url))
            ->each(fn($link) => UriResolver::resolve($link->attr('href'), $url));

        return collect($childrenLinks)->filter(fn($link) => $link !== $url);
    }

    private function getChildrenLinksSelector(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        return 'a[href^="' . $path . '"]:not([href="' . $path . '"]), a[href^="' . $url . '"]:not([href="' . $url . '"])';
    }
}
