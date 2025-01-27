<?php

/*
 * This file is part of the PDF Version Converter.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Rosegaar\PDFVersionConverter\Converter;

use \PHPUnit_Framework_TestCase;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

/**
 */
class GhostscriptConverterTest extends PHPUnit_Framework_TestCase
{
    protected $tmp;

    protected function setUp()
    {
        $this->tmp = __DIR__.'/../files/stage/';

        if (!file_exists($this->tmp))
            mkdir($this->tmp);
    }

    protected function tearDown()
    {
    }

    /**
     * @param string $file
     * @param $newVersion
     *
     * @dataProvider filesProvider
     */
    public function testMustConvertPDFVersionWithSuccess($file, $newVersion)
    {
        $fs = $this->prophesize('\Symfony\Component\Filesystem\Filesystem');
        $fs->exists(Argument::type('string'))
           ->willReturn(true)
           ->shouldBeCalled()
        ;
        $fs->copy(
                Argument::type('string'),
                $file,
                true
            )
            ->willReturn(true)
            ->shouldBeCalled()
        ;

        $command = $this->prophesize('Rosegaar\PDFVersionConverter\Converter\GhostscriptConverterCommand');
        $command->run(
                $file,
                Argument::type('string'),
                $newVersion
            )
            ->willReturn(null)
            ->shouldBeCalled()
        ;

        $converter = new GhostscriptConverter(
            $command->reveal(),
            $fs->reveal(),
            $this->tmp
        );

        $converter->convert($file, $newVersion);
    }

    /**
     * @return array
     */
    public static function filesProvider()
    {
        return array(
            // file, new version
            array(__DIR__ . '/../files/stage/v1.1.pdf', '1.4'),
            array(__DIR__ . '/../files/stage/v1.2.pdf', '1.4'),
            array(__DIR__ . '/../files/stage/v1.3.pdf', '1.4'),
            array(__DIR__ . '/../files/stage/v1.4.pdf', '1.4'),
            array(__DIR__ . '/../files/stage/v1.5.pdf', '1.4'),
            array(__DIR__ . '/../files/stage/v1.6.pdf', '1.4'),
            array(__DIR__ . '/../files/stage/v1.7 filename with "Sp3ci4l"; <\'Ch4r5\'> !£$%&()=?^[]{}è@#§.pdf', '1.4'),
            array(__DIR__ . '/../files/stage/v1.7.pdf', '1.4'),
            array(__DIR__ . '/../files/stage/v2.0.pdf', '1.4'),
        );
    }
}