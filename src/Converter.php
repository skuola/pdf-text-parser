<?php

namespace Skuola\PdfTextParser;

use Symfony\Component\DomCrawler\Crawler;

class Converter
{
    private $rows = [];

    public function __construct(?string $data, ?string $path = null, ?int $startPage = 0, ?int $numOfPages = 1)
    {
        if (null === $data && null === $path) {
            throw new \InvalidArgumentException('You must pass data or a file path.');
        }
        if (null !== $path && false === $data = @file_get_contents($path)) {
            throw new \UnexpectedValueException('Cannot read file.');
        }
        $this->convert($data, $startPage, $numOfPages);
    }

    public function getAsText(): string
    {
        $output = '';
        foreach ($this->rows as $row) {
            $output .= $row.\PHP_EOL;
        }

        return $output;
    }

    public function getSubstringHtml(int $numberOfCharacters, bool $escape = false, bool $random = false): string
    {
        $output = '';
        $checkOutput = '';
        $startRow = 0;

        if ($random) {


            $rowsToTake = intval((count($this->rows) - 1) * 0.5);
            $rows = array_slice($this->rows, 0, $rowsToTake);

            // Check for titles
            $titles = array_filter($rows, function ($row) {
                return $row->isTitle();
            });

            /**
             * If there is at least one title
             * take the first title as starting point
             */
            if (count($titles) > 0) {
                $startRow = array_search($titles[array_key_first($titles)], $rows);
            }

            /**
             * Else take a random row as starting point
             */
            else {
                $startRow = rand(0, $rowsToTake);
            }

        } else {
            $rows = $this->rows;
        }

        for ($i = $startRow; $i < count($rows) - 1; $i++) {

            $row = $this->rows[$i];

            $checkOutput .= $row;

            if (\strlen($checkOutput) > $numberOfCharacters) {
                break;
            }

            $html = (true === $escape) ? htmlentities($row, \ENT_QUOTES) : $row;
            $output .= $row->isTitle() ? '<h2>'.$html.'</h2>' : '<p>'.$html.'</p>';

        }

        return $output;
    }

    public function getAsHtml(bool $escape = false): string
    {
        $output = '';
        foreach ($this->rows as $row) {
            $html = (true === $escape) ? htmlentities($row, \ENT_QUOTES) : $row;
            $output .= $row->isTitle() ? '<h2>'.$html.'</h2>' : '<p>'.$html.'</p>';
        }

        return $output;
    }

    private function convert(string $data, int $startPage, int $numOfPages): void
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent($data);
        $pages = $crawler->filter('body > doc > page');
        $ws = [];
        foreach ($pages as $number => $domElement) {
            if ($number >= $startPage && $number < $startPage + $numOfPages) {
                foreach ($domElement->childNodes as $word) {
                    if (null !== $word->attributes) {
                        $ws[] = [
                            'text' => $word->nodeValue,
                            'xmin' => (float) $word->attributes->getNamedItem('xmin')->value,
                            'ymin' => (float) $word->attributes->getNamedItem('ymin')->value,
                            'xmax' => (float) $word->attributes->getNamedItem('xmax')->value,
                            'ymax' => (float) $word->attributes->getNamedItem('ymax')->value,
                        ];
                    }
                }
            }
        }
        foreach ($ws as $n => $w) {
            if ($n < 1 || $w['xmin'] < $ws[$n - 1]['xmax']) {
                $row = new Row();
                $this->rows[] = $row;
            }
            new Word($w['text'], $row, $w['xmin'], $w['xmax'], $w['ymin'], $w['ymax']);
        }
    }
}
