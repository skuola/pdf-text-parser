<?php
// read a file and output result as text

require_once __DIR__.'/../vendor/autoload.php';

$file = $_SERVER['argv'][1] ?? __DIR__.'/../data/example1.html';
try {
    $converter = new \Skuola\PdfTextParser\Converter(null, $file);
    $txt = $converter->getAsText();
    echo PHP_EOL.$txt.PHP_EOL;
} catch (\Exception $e) {
    echo $e;
}
