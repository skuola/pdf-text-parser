<?php
// read a file and output result as html

require_once __DIR__.'/../vendor/autoload.php';

$file = $_SERVER['argv'][1] ?? __DIR__.'/../data/example1.html';
try {
    $converter = new \Skuola\PdfTextParser\Converter(null, $file);
    $html = $converter->getAsHtml();
    echo "<!DOCTYPE html><html><head><meta charset=\"UTF-8\"></head><body>$html</body></html>";
} catch (\Exception $e) {
    echo $e;
}
