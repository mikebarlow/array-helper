<?php
namespace Snscripts\ArrayHelper\Tests;

use Snscripts\ArrayHelper\ArrayHelper;

class ArrayHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $this->assertInstanceOf(
            'Snscripts\ArrayHelper\ArrayHelper',
            new ArrayHelper(
                []
            )
        );

        $this->assertInstanceOf(
            'Snscripts\ArrayHelper\ArrayHelper',
            new ArrayHelper(
                ['foo', 'bar', 'foobar']
            )
        );
    }

    public function testConstructThrowExceptionWithString()
    {
        $this->setExpectedException('InvalidArgumentException');

        $ArrayHelper = new ArrayHelper('string');
    }

    public function testConstructThrowExceptionWithObject()
    {
        $this->setExpectedException('InvalidArgumentException');

        $ArrayHelper = new ArrayHelper(
            new \StdClass()
        );
    }

    public function testConstructThrowExceptionWithNull()
    {
        $this->setExpectedException('InvalidArgumentException');

        $ArrayHelper = new ArrayHelper(null);
    }

    public function testOutputReturnsArray()
    {
        $ArrayHelper = new ArrayHelper(['foo', 'bar']);

        $this->assertSame(
            ['foo', 'bar'],
            $ArrayHelper->output()
        );

        $ArrayHelper->help(['new', 'array']);

        $this->assertSame(
            ['new', 'array'],
            $ArrayHelper->output()
        );
    }

    public function testSplitArraySetsCorrectArray()
    {
        $arr = ['this', 'is', 'a', 'big', 'array', 'to', 'split', 'up'];

        $ArrayHelper = new ArrayHelper($arr);
        $ArrayHelper->splitArray(4);

        $this->assertSame(
            [
                [
                    0 => 'this',
                    1 => 'is'
                ],
                [
                    2 => 'a',
                    3 => 'big'
                ],
                [
                    4 => 'array',
                    5 => 'to'
                ],
                [
                    6 => 'split',
                    7 => 'up'
                ]
            ],
            $ArrayHelper->output()
        );

        $newArr = ['this', 'array', 'has', 'odd', 'num'];
        $ArrayHelper->help($newArr);
        $ArrayHelper->splitArray(2);

        $this->assertSame(
            [
                [
                    0 => 'this',
                    1 => 'array',
                    2 => 'has'
                ],
                [
                    3 => 'odd',
                    4 => 'num'
                ]
            ],
            $ArrayHelper->output()
        );
    }


}
