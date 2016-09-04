<?php
namespace Snscripts\ArrayHelper\Tests;

class ArrayUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testClearArrayWrapper()
    {
        $arr = ['', 'foo', null, 'bar', 'foobar', 'test', '0'];

        $this->assertSame(
            [1 => 'foo', 3 => 'bar', 4 => 'foobar', 5 => 'test'],
            \ArrayUtil::clearArray($arr)
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
            \ArrayUtil::clearArray($arr)
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
            \ArrayUtil::splitArray(
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
            \ArrayUtil::splitArray(
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
            \ArrayUtil::splitArray(
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
            \ArrayUtil::splitArray(
                [1, 2, 3, 4, 5, 6, 7],
                3
            )
        );
    }

}
