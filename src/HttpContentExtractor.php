<?php

namespace Ditcher;

use Ditcher\Contracts\Content;
use Ditcher\Contracts\ContentExtractor;

class HttpContentExtractor implements ContentExtractor
{
    public function extract(): Content
    {
        $client = new \Goutte\Client();

        $crawler = $client->request('GET', 'https://epayment.kz/docs');

        /** @var \Symfony\Component\DomCrawler\Crawler $menu */
        $menu = $crawler->filter('[class^="DocumentationSideNav_sideNav"]')->each(function ($node) {
            return $node;
        })[0];

//    dd($menu);

        $links = $menu->filter('ul a');

        $pages = [];
        $links
            ->each(function (/** @var \Symfony\Component\DomCrawler\Crawler $node */ $node) use (&$pages) {
                $customClient = new \Goutte\Client();

                $pages[$node->text()] = [
                    'href' => $node->attr('href'),
                    'html' => $customClient->click($node->link())->html()
                ];
            });

        return $pages['Cancelling payment']['html'];
    }
}