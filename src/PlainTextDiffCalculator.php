<?php

namespace Ditcher;

use App\Models\DumpDiff;
use App\Models\Page;
use App\Models\PageDump;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

class PlainTextDiffCalculator
{
    public function calculate(string $old, string $new): string
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


    /**
     * @param Page[] $pages
     * @return void
     */
    public function calculateDiffForPagesDumps(array $pages): void
    {
        foreach ($pages as $page) {
            $page->load('lastTwoDumps');

            if ($page->lastTwoDumps->count() === 2) {
                /** @var PageDump $old */
                $old = $page->lastTwoDumps[1];
                /** @var PageDump $new */
                $new = $page->lastTwoDumps[0];

                $diff = new DumpDiff();
                $diff->page_old_dump_id = $old->id;
                $diff->page_new_dump_id = $new->id;

                if ($old->hash === $new->hash) {
                    $diff->html = null;
                    $diff->json = null;
                    $diff->diff_type_id = null; // todo

                } else {
                    $result = $this->calculate($old->pretty_html,$new->pretty_html);
                    dd($result);
                }

                $diff->save();
            }
        }
    }
}