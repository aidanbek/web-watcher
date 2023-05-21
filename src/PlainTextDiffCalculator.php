<?php

namespace Ditcher;

use App\Models\DiffType;
use App\Models\DumpDiff;
use App\Models\Page;
use App\Models\PageDump;
use Illuminate\Hashing\HashManager;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

class PlainTextDiffCalculator
{
    public function __construct(
        private readonly HashManager $hashManager,
    )
    {
    }

    private const EMPTY_HTML = '';
    private const EMPTY_JSON = '[]';

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

                if ($this->hashManager->check($oldDump->raw_html, $newDump->hash)) {
                    $diff->html = PlainTextDiffCalculator::EMPTY_HTML;
                    $diff->json = PlainTextDiffCalculator::EMPTY_JSON;
                    $diff->diff_type_id = DiffType::NO_CHANGES;
                } else {
                    $diff->json = $this->calculateJson($oldDump->raw_pretty_html, $newDump->raw_pretty_html);
                    $diff->html = $this->calculateHtml($oldDump->raw_pretty_html, $newDump->raw_pretty_html);
                    $diff->diff_type_id = DiffType::HAS_CHANGES;
                }

                $diff->save();
            }
        }
    }
}