<?php
namespace Snscripts\ArrayHelper\Tests;

use ArrayUtil;

class ArrayUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testClearArrayWrapper()
    {
        $arr = ['', 'foo', null, 'bar', 'foobar', 'test', '0'];

        $this->assertSame(
            [1 => 'foo', 3 => 'bar', 4 => 'foobar', 5 => 'test'],
            ArrayUtil::clearArray($arr)
        );

        $arr = [
            'foo', '', 'test', [
                'hello', '', 'bye'
            ]
        ];

        $this->assertSame(
            [
                0 => 'foo',
                2 => 'test',
                3 => [
                    0 => 'hello', 2 => 'bye'
                ]
            ],
            ArrayUtil::clearArray($arr)
        );
    }

    public function testSplitArrayWrapper()
    {
        $this->assertSame(
            [
                [
                    0 => 'small'
                ],
                [
                    1 => 'array'
                ]
            ],
            ArrayUtil::splitArray(
                ['small', 'array'],
                3
            )
        );

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
            ArrayUtil::splitArray(
                ['this', 'is', 'a', 'big', 'array', 'to', 'split', 'up'],
                4
            )
        );

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
            ArrayUtil::splitArray(
                ['this', 'array', 'has', 'odd', 'num'],
                2
            )
        );

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
            ArrayUtil::splitArray(
                [1, 2, 3, 4, 5, 6, 7],
                3
            )
        );
    }

    public function testAddArrayWrapper()
    {
        $this->assertSame(
            [
                'a' => 'foo',
                'c' => 'test',
                'b' => 'bar'
            ],
            ArrayUtil::addAfter(
                [
                    'a' => 'foo',
                    'b' => 'bar'
                ],
                'a',
                [
                    'c' => 'test'
                ]
            )
        );
    }

    public function testGetOffsetByKeyReturnsOffsetPositionInArray()
    {
        $this->assertSame(
            1,
            ArrayUtil::getOffsetByKey(
                [
                    'a' => 'Alpha',
                    'b' => 'Bravo',
                    'c' => 'Charlie'
                ],
                'b'
            )
        );
    }

    public function testGetOffsetByKeyReturnsNullWhenNotFound()
    {
        $this->assertNull(
            ArrayUtil::getOffsetByKey(
                [
                    'a' => 'Alpha',
                    'b' => 'Bravo',
                    'c' => 'Charlie'
                ],
                'd'
            )
        );
    }

    public function testGetOffsetByValueReturnsOffsetPositionInArray()
    {
        $this->assertSame(
            2,
            ArrayUtil::getOffsetByValue(
                [
                    'a' => 'Alpha',
                    'b' => 'Bravo',
                    'c' => 'Charlie'
                ],
                'Charlie'
            )
        );
    }

    public function testGetOffsetByValueReturnsNullWhenNotFound()
    {
        $this->assertNull(
            ArrayUtil::getOffsetByValue(
                [
                    'a' => 'Alpha',
                    'b' => 'Bravo',
                    'c' => 'Charlie'
                ],
                'Delta'
            )
        );
    }

    public function testMoveItemMovesAnElementCorrectly()
    {
        $this->assertSame(
            [
                'a' => 'alpha',
                'c' => 'charlie',
                'b' => 'bravo'
            ],
            ArrayUtil::moveItem(
                [
                    'a' => 'alpha',
                    'b' => 'bravo',
                    'c' => 'charlie'
                ],
                'b',
                'c'
            )
        );
    }

    public function testMoveItemThrowsExceptionWithInvalidItems()
    {
        $this->setExpectedException('InvalidArgumentException');

        ArrayUtil::moveItem(
            [
                'a' => 'alpha',
                'b' => 'bravo',
                'c' => 'charlie'
            ],
            'e',
            'f'
        );
    }

    public function testCartesianProductProducesCorrectArray()
    {
        $this->assertSame(
            [
                ['S', 'Red'],
                ['S', 'Blue'],
                ['M', 'Red'],
                ['M', 'Blue'],
                ['L', 'Red'],
                ['L', 'Blue']
            ],
            ArrayUtil::cartesianProduct([
                ['S', 'M', 'L'],
                ['Red', 'Blue']
            ])
        );
    }
}
