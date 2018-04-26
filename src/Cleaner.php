<?php

namespace Skuola\PdfTextParser;

final class Cleaner
{
    private static $tr = [
        'Â' => '',
        'Ã ' => 'à',
        'Ã¨' => 'è',
        'Ã©' => 'é',
        'Ã¬' => 'ì',
        'Ã²' => 'ò',
        'Ã¹' => 'ù',
        'â' => "'",
        'â' => '-',
        'â' => '"',
        'â' => '"',
        'â' => '⊃',
        'â' => '⊂',
        'â' => '⊇',
        'â' => '⊆',
        'âª' => '∪',
        'â©' => '∩',
        'â' => '∅',
        'â¦' => '...',
        'â¢' => '•',
        'â¦' => '◦',
        'ï ' => ':',
        'â' => '\'',
    ];

    public static function clear(string $input): string
    {
        return strtr($input, self::$tr);
    }
}
