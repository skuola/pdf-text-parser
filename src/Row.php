<?php

namespace Skuola\PdfTextParser;

class Row
{
    private const TITLE_THRESHOLD = 0.8;

    /**
     * @var array|Word[]
     */
    public $words;

    public function __toString(): string
    {
        return implode(' ', $this->words);
    }

    /**
     * A row is a title if most of its words are in uppercase.
     *
     * @return bool
     */
    public function isTitle(): bool
    {
        if (\count($this->words) < 1) {
            return false;
        }
        $uppers = 0;
        foreach ($this->words as $word) {
            $uppers += ctype_upper(preg_replace('/\W+/', '', $word->text)) ? 1 : 0;
        }

        return $uppers / \count($this->words) >= self::TITLE_THRESHOLD;
    }
}
