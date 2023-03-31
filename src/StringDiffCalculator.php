<?php

namespace Ditcher;

use Ditcher\Contracts\Diff;
use Ditcher\Contracts\DiffCalculator;

class StringDiffCalculator implements DiffCalculator
{
    public function calculate($old, $new): Diff
    {
        $diffOptions = [
            // show how many neighbor lines
            // Differ::CONTEXT_ALL can be used to show the whole file
            'context'          => 1,
            // ignore case difference
            'ignoreCase'       => false,
            // ignore line ending difference
            'ignoreLineEnding' => false,
            // ignore whitespace difference
            'ignoreWhitespace' => false,
        ];

        $rendererOptions = [
            'cliColorization' => \Jfcherng\Diff\Renderer\RendererConstant::CLI_COLOR_AUTO,
            'detailLevel'     => 'word'
        ];

        $diff = \Jfcherng\Diff\DiffHelper::calculate(
            old            : $old,
            new            : $new,
            renderer       : 'SideBySide',
            differOptions  : $diffOptions,
            rendererOptions: $rendererOptions
        );

        return $diff;
    }
}