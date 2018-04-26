<?php

namespace Skuola\PdfTextParser\Test;

use PHPUnit\Framework\TestCase;
use Skuola\PdfTextParser\Cleaner;

final class CleanerTest extends TestCase
{
    public function testClear(): void
    {
        $this->assertEquals('città', Cleaner::clear('cittÃ '));
    }
}
