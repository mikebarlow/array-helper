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
        $ArrayHelper = new ArrayHelper([]);

        $ArrayHelper->help(['small', 'array']);
        $ArrayHelper->splitArray(3);

        $this->assertSame(
            [
                [
                    0 => 'small'
                ],
                [
                    1 => 'array'
                ]
            ],
            $ArrayHelper->output()
        );

        $arr = ['this', 'is', 'a', 'big', 'array', 'to', 'split', 'up'];
        $ArrayHelper->help($arr);
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

        $newArr = [1, 2, 3, 4, 5, 6, 7];
        $ArrayHelper->help($newArr);
        $ArrayHelper->splitArray(3);

        $this->assertSame(
            [
                [
                    0 => 1,
                    1 => 2,
                    2 => 3
                ],
                [
                    3 => 4,
                    4 => 5
                ],
                [
                    5 => 6,
                    6 => 7
                ]
            ],
            $ArrayHelper->output()
        );
    }

    public function testClearArrayRemovesEmptyElements()
    {
        $ArrayHelper = new ArrayHelper(['', 'foo', null, 'bar', 'foobar', 'test', '0']);
        $ArrayHelper->clearArray();

        $this->assertSame(
            [1 => 'foo', 3 => 'bar', 4 => 'foobar', 5 => 'test'],
            $ArrayHelper->output()
        );

        $ArrayHelper->help([
            'foo', '', 'test', [
                'hello', '', 'bye'
            ]
        ]);
        $ArrayHelper->clearArray();

        $this->assertSame(
            [
                0 => 'foo',
                2 => 'test',
                3 => [
                    0 => 'hello', 2 => 'bye'
                ]
            ],
            $ArrayHelper->output()
        );
    }

    public function testAddAfterAddsElementCorrectly()
    {
        $ArrayHelper = new ArrayHelper([
            'a' => 'foo',
            'b' => 'bar'
        ]);
        $ArrayHelper->addAfter(
            'a',
            [
                'c' => 'test'
            ]
        );

        $this->assertSame(
            [
                'a' => 'foo',
                'c' => 'test',
                'b' => 'bar'
            ],
            $ArrayHelper->output()
        );
    }

    public function testMoveItemMovesAnElementCorrectly()
    {
        $ArrayHelper = new ArrayHelper([
            'a' => 'alpha',
            'b' => 'bravo',
            'c' => 'charlie'
        ]);

        $ArrayHelper->moveItem(
            'b',
            'c'
        );

        $this->assertSame(
            [
                'a' => 'alpha',
                'c' => 'charlie',
                'b' => 'bravo'
            ],
            $ArrayHelper->output()
        );
    }

    public function testMoveItemThrowsExceptionWithInvalidItems()
    {
        $this->setExpectedException('InvalidArgumentException');

        $ArrayHelper = new ArrayHelper([
            'a' => 'alpha',
            'b' => 'bravo',
            'c' => 'charlie'
        ]);

        $ArrayHelper->moveItem(
            'e',
            'f'
        );
    }

    public function testCartesianProductProducesCorrectArray()
    {
        $ArrayHelper = new ArrayHelper([
            ['S', 'M', 'L'],
            ['Red', 'Blue']
        ]);

        $ArrayHelper->cartesianProduct();

        $this->assertSame(
            [
                ['S', 'Red'],
                ['S', 'Blue'],
                ['M', 'Red'],
                ['M', 'Blue'],
                ['L', 'Red'],
                ['L', 'Blue']
            ],
            $ArrayHelper->output()
        );
    }

    public function testGetOffsetByKeyReturnsOffsetPositionInArray()
    {
        $ArrayHelper = new ArrayHelper([
            'a' => 'Alpha',
            'b' => 'Bravo',
            'c' => 'Charlie'
        ]);

        $this->assertSame(
            1,
            $ArrayHelper->getOffsetByKey('b')
        );
    }

    public function testGetOffsetByKeyReturnsNullWhenNotFound()
    {
        $ArrayHelper = new ArrayHelper([
            'a' => 'Alpha',
            'b' => 'Bravo',
            'c' => 'Charlie'
        ]);

        $this->assertNull(
            $ArrayHelper->getOffsetByKey('d')
        );
    }

    public function testGetOffsetByValueReturnsOffsetPositionInArray()
    {
        $ArrayHelper = new ArrayHelper([
            'a' => 'Alpha',
            'b' => 'Bravo',
            'c' => 'Charlie'
        ]);

        $this->assertSame(
            2,
            $ArrayHelper->getOffsetByValue('Charlie')
        );
    }

    public function testGetOffsetByValueReturnsNullWhenNotFound()
    {
        $ArrayHelper = new ArrayHelper([
            'a' => 'Alpha',
            'b' => 'Bravo',
            'c' => 'Charlie'
        ]);

        $this->assertNull(
            $ArrayHelper->getOffsetByValue('Delta')
        );
    }

    public function testArrayableInterfaceMethods()
    {
        $ArrayHelper = new ArrayHelper([]);
        $ArrayHelper['foo'] = 'bar';
        $ArrayHelper[] = 'test';

        $this->assertSame(
            [
                'foo' => 'bar',
                0 => 'test'
            ],
            $ArrayHelper->output()
        );

        $ArrayHelper['fizz'] = 'buzz';

        $this->assertTrue(
            isset($ArrayHelper['fizz'])
        );

        unset($ArrayHelper['foo']);
        $this->assertSame(
            [
                0 => 'test',
                'fizz' => 'buzz'
            ],
            $ArrayHelper->output()
        );

        $this->assertSame(
            'buzz',
            $ArrayHelper['fizz']
        );
    }

    public function testIteratorInterfaceMethods()
    {
        $ArrayHelper = new ArrayHelper([
            'a' => 'Alpha',
            'b' => 'Bravo',
            'c' => 'Charlie',
            'd' => 'Delta'
        ]);

        $this->assertSame(
            'Alpha',
            $ArrayHelper->rewind()
        );

        $ArrayHelper->next();

        $this->assertSame(
            'Bravo',
            $ArrayHelper->current()
        );

        $this->assertSame(
            'b',
            $ArrayHelper->key()
        );

        $this->assertSame(
            'Charlie',
            $ArrayHelper->next()
        );

        $this->assertTrue(
            $ArrayHelper->valid()
        );

        $ArrayHelper->next();
        $ArrayHelper->next();

        $this->assertFalse(
            $ArrayHelper->valid()
        );
    }

}
