<?php

namespace Ditcher;

use App\Models\DumpDiff;
use App\Models\Page;
use App\Models\PageDump;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

class PlainTextDiffCalculator
{
    public function calculateJson(string $old, string $new): string
    {
        $differOptions = [
            'context'          => 1,
            'ignoreCase'       => false,
            'ignoreLineEnding' => false,
            'ignoreWhitespace' => false,
        ];

        $rendererOptions = [
            'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
            'detailLevel'     => 'char'
        ];

        return DiffHelper::calculate(
            old            : $old,
            new            : $new,
            renderer       : 'JsonHtml',
            differOptions  : $differOptions,
            rendererOptions: $rendererOptions
        );
    }

    public function calculateHtml(string $old, string $new): string
    {
        $differOptions = [
            'context'          => 1,
            'ignoreCase'       => false,
            'ignoreLineEnding' => false,
            'ignoreWhitespace' => false,
        ];

        $rendererOptions = [
            'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
            'detailLevel'     => 'char'
        ];

        return DiffHelper::calculate(
            old            : $old,
            new            : $new,
            renderer       : 'SideBySide',
            differOptions  : $differOptions,
            rendererOptions: $rendererOptions
        );
    }


    /**
     * @param Page[] $pages
     * @return void
     */
    public function calculateDiffForPagesDumps(array $pages): void
    {
        foreach ($pages as $page) {
            $page->load('lastTwoDumps');

            if ($page->lastTwoDumps->count() === 2) {
                /** @var PageDump $oldDump */
                $oldDump = $page->lastTwoDumps[1];
                /** @var PageDump $newDump */
                $newDump = $page->lastTwoDumps[0];

                $diff = new DumpDiff();
                $diff->page_old_dump_id = $oldDump->id;
                $diff->page_new_dump_id = $newDump->id;
                $diff->diff_type_id = null;// todo

                if ($oldDump->hash === $newDump->hash) {
                    $diff->html = null;
                    $diff->json = null;
                } else {
                    $oldPrettyHtml = htmlspecialchars_decode($oldDump->pretty_html);
                    $newPrettyHtml = htmlspecialchars_decode($newDump->pretty_html);
                    $diff->json = $this->calculateJson($oldPrettyHtml, $newPrettyHtml);
                    $diff->html = $this->calculateHtml($oldPrettyHtml, $newPrettyHtml);
                }

                $diff->save();
            }
        }
    }
}