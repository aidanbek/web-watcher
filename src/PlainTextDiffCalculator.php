<?php

namespace Ditcher;

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
}