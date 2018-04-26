<?php

namespace Skuola\PdfTextParser;

class Word
{
    /**
     * @var string
     */
    public $text;

    /**
     * @var Row
     */
    public $row;

    /**
     * @var array
     */
    public $x;

    /**
     * @var array
     */
    public $y;

    /**
     * @var float
     */
    public $height;

    /**
     * @var float
     */
    public $width;

    public function __construct(string $text, Row $row, float $xmin, float $xmax, float $ymin, float $ymax)
    {
        $this->text = $text;
        $this->row = $row;
        $row->words[] = $this;
        $this->x = [$xmin, $xmax];
        $this->y = [$ymin, $ymax];
        $this->height = $ymax - $ymin;
        $this->width = $xmax - $xmin;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
