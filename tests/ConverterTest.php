<?php

namespace Skuola\PdfTextParser\Test;

use PHPUnit\Framework\TestCase;
use Skuola\PdfTextParser\Converter;

final class ConverterTest extends TestCase
{
    public function testConstructWithWrongParamsShouldFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Converter(null);
    }

    public function testConstructWithWrongPathShouldFail(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        new Converter(null, 'doesnotexist');
    }

    /**
     * @dataProvider textProvider
     *
     * @param string $in
     * @param string $out
     */
    public function testItShouldConvertBasicContent(string $in, string $out): void
    {
        $converter = new Converter($in);
        $this->assertEquals($out, $converter->getAsText());
    }

    public function testItShouldConvertUtf8Content(): void
    {
        $in = '<body><doc><page><word xMin="159.799000" yMin="355.437050" xMax="167.547910" yMax="364.841744">ξ ≤ ∃ϕ → ∧∀</word></page></doc></body>';
        $out = '<p>ξ ≤ ∃ϕ → ∧∀</p>';
        $converter = new Converter($in);
        $this->assertEquals($out, $converter->getAsHtml());
    }

    public function testItShouldFindTitle(): void
    {
        $in = '<body><doc><page><word xMin="56.640000" yMin="59.770680" xMax="118.022880" yMax="72.406680">TITLE</word></page></doc></body>';
        $out = '<h2>TITLE</h2>';
        $converter = new Converter($in);
        $this->assertEquals($out, $converter->getAsHtml());
    }

    public function testItShouldNotFindTitle(): void
    {
        $in = '<body><doc><page><word xMin="56.640000" yMin="59.770680" xMax="118.022880" yMax="72.406680">NOT A title</word></page></doc></body>';
        $out = '<p>NOT A title</p>';
        $converter = new Converter($in);
        $this->assertEquals($out, $converter->getAsHtml());
    }

    public function textProvider(): array
    {
        return [
            'with single row' => [
                'in' => '<body><doc><page><word xMin="56.640000" yMin="59.770680" xMax="118.022880" yMax="72.406680">foo</word><word xMin="121.209960" yMin="59.770680" xMax="176.485440" yMax="72.406680">bar</word></page></doc></body>',
                'out' => 'foo bar'.PHP_EOL,
            ],
            'with two rows' => [
                'in' => '<body><doc><page><word xMin="56.640000" yMin="59.770680" xMax="118.022880" yMax="72.406680">foo</word><word xMin="121.209960" yMin="59.770680" xMax="176.485440" yMax="72.406680">bar</word><word xMin="91.944000" yMin="91.544000" xMax="104.472000" yMax="102.344000">baz</word></page></doc></body>',
                'out' => 'foo bar'.PHP_EOL.'baz'.PHP_EOL,
            ],
        ];
    }
}
