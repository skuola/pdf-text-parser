PDF text parser
===============

[![Build Status](https://travis-ci.org/skuola/pdf-text-parser.png?branch=master)](https://travis-ci.org/skuola/pdf-text-parser)
[![Code Climate](https://codeclimate.com/github/skuola/pdf-text-parser/badges/gpa.svg)](https://codeclimate.com/github/skuola/pdf-text-parser)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5409d200-2a71-4486-824d-f890791308ea/mini.png)](https://insight.sensiolabs.com/projects/5409d200-2a71-4486-824d-f890791308ea)

This library is a parser for XML text files obtained via [pdftotext](https://en.wikipedia.org/wiki/Pdftotext)

You can install it using `composer require skuola/pdf-text-parser`

Suppose you're just converted a pdf file, getting some text like the following:

```
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<doc>
  <page width="595.200000" height="841.800000">
    <word xMin="56.640000" yMin="59.770680" xMax="118.022880" yMax="72.406680">Lorem</word>
    <word xMin="121.209960" yMin="59.770680" xMax="176.485440" yMax="72.406680">ipsum</word>
  </page>
</doc>
</body>
</html>
```

The above text is the result of a command like `pdftotext -htmlmeta -bbox-layout yourfile.pdf -`.

You can use this library as follows:

```php
<?php

require_once 'vendor/autoload.php';

$data = '...';  // the text above

$converter = new \Skuola\PdfTextParser\Converter($data);
// get as plain text...
$txt = $converter->getAsText();
// ...or get as HTML
$html = $converter->getAsHtml();
```

As alternate mode, you can save your HTML file and pass it to library:

```php
<?php

require_once 'vendor/autoload.php';

$path = '...';  // a path containing the same text as previous example

$converter = new \Skuola\PdfTextParser\Converter(null, $path);
$html = $converter->getAsHtml();
```

Generated HTML is composed by a `<h2>` tag or an `<p>` tag  for each
document line (depending on the line being a title or not).

More informations to come...
