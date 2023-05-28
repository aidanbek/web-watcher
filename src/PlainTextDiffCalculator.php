<?php

namespace Ditcher;

use App\Models\DiffType;
use App\Models\DumpDiff;
use App\Models\Page;
use App\Models\PageDump;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

class PlainTextDiffCalculator
{
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
            'cliColorization'   => RendererConstant::CLI_COLOR_AUTO,
            'outputTagAsString' => true,
            'detailLevel'       => 'char'
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
            'cliColorization'   => RendererConstant::CLI_COLOR_AUTO,
            'outputTagAsString' => true,
            'detailLevel'       => 'char'
        ];

        return DiffHelper::calculate(
            old            : $old,
            new            : $new,
            renderer       : 'SideBySide',
            differOptions  : $differOptions,
            rendererOptions: $rendererOptions
        );
    }

    public function calculateDiffForDumps(PageDump $oldDump, PageDump $newDump): array
    {
        $result = [];

        if ($oldDump->hash === $newDump->hash) {
            $result['html'] = PlainTextDiffCalculator::EMPTY_HTML;
            $result['json'] = PlainTextDiffCalculator::EMPTY_JSON;
            $result['diff_type_id'] = DiffType::NO_CHANGES;
        } else {
            $result['json'] = $this->calculateJson($oldDump->raw_pretty_html, $newDump->raw_pretty_html);
            $result['html'] = $this->calculateHtml($oldDump->raw_pretty_html, $newDump->raw_pretty_html);

            if ($result['json'] === self::EMPTY_JSON || $result['html'] === self::EMPTY_HTML) {
                $result['diff_type_id'] = DiffType::NO_CHANGES;
            } else {
                $result['diff_type_id'] = DiffType::HAS_CHANGES;
            }
        }

        return $result;
    }

    private function calculateDiffForPage(Page $page)
    {
        $page->load('lastTwoDumps');

        if ($page->lastTwoDumps->count() === 2) {
            $oldDump = $page->lastTwoDumps[1];
            $newDump = $page->lastTwoDumps[0];

            $result = $this->calculateDiffForDumps($oldDump, $newDump);

            $diff = new DumpDiff();
            $diff->page_old_dump_id = $oldDump->id;
            $diff->page_new_dump_id = $newDump->id;
            $diff->html = $result['html'];
            $diff->json = $result['json'];
            $diff->diff_type_id = $result['diff_type_id'];

            $diff->save();
        }
    }


    /**
     * @param Page[] $pages
     * @return void
     */
    public function calculateDiffForPages(array $pages): void
    {
        foreach ($pages as $page) {
            $this->calculateDiffForPage($page);
        }
    }
}