<?php

namespace App\View\Composers;

use Illuminate\View\View;

class HighlightWord
{
    public string $highlightedText;

    public function __construct(
        string $text,
        array|string $word,
        string $color = '#a59060',
        bool $bold = true
    ) {
        $style = "color: {$color};";
        if ($bold) {
            $style .= " font-weight: bold;";
        }

        $words = is_array($word) ? $word : [$word];

        $highlighted = $text;

        foreach ($words as $w) {
            $replacement = "<span style=\"{$style}\">{$w}</span>";

            $highlighted = preg_replace(
                "/(" . preg_quote($w, '/') . ")/i",
                $replacement,
                $highlighted
            );
        }

        $this->highlightedText = $highlighted;
    }

    public function compose(View $view): void
    {
        $view->with('highlightedText', $this->highlightedText);
    }
}
