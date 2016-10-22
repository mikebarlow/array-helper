# Framework Agnostic Array-Helper

[![Author](http://img.shields.io/badge/author-@mikebarlow-red.svg?style=flat-square)](https://twitter.com/mikebarlow)
[![Source Code](http://img.shields.io/badge/source-snscripts/array--helper-brightgreen.svg?style=flat-square)](https://github.com/mikebarlow/array-helper)
[![Latest Version](https://img.shields.io/github/release/mikebarlow/array-helper.svg?style=flat-square)](https://github.com/mikebarlow/array-helper/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/mikebarlow/array-helper/blob/master/LICENSE)
[![Build Status](https://img.shields.io/travis/mikebarlow/array-helper/master.svg?style=flat-square)](https://travis-ci.org/mikebarlow/array-helper)

## Introduction

This Array Helper is a PSR-2 Compliant Framework Agnostic helper designed for help to manipulate arrays in certain ways not currently possible with built in PHP functions. Plus with added "Collections" style functionality.

## Requirements

### Composer

Array Helper requires the following:

* "php": ">=5.4.0"

And the following if you wish to run in dev mode and run tests.

* "phpunit/phpunit": "~4.0"
* "squizlabs/php_codesniffer": "~2.0"

## Installation

### Composer

Simplest installation is via composer.

    composer require snscripts/array-helper 1.*

or adding to your projects `composer.json` file.

    {
        "require": {
            "snscripts/array-helper": "1.*"
        }
    }

### Setup

To set up ready for use simply create an instance of the ArrayHelper and pass in the array you want to manipulate as the constructor.

    $ArrayHelper = new \Snscripts\ArrayHelper\ArrayHelper([
        'a' => 'Alpha',
        'b' => 'Bravo',
        'c' => 'Charlie',
        'd' => 'Delta'
    ]);

Alternatively, if the object has already been created, simply pass in the array to the `help` method to start working on that array.

    $ArrayHelper->help(['replacement' => 'array']);

## Usage

All methods other than, `output()`, `getOffsetByKey()` and `getOffsetByValue()` all methods return `$this` to allow method chaining.

### output()

    // Returns the array in it's current state
    $ArrayHelper->output();

This method simply returns the array in it's current state.

### clearArray()

    // Clears empty() elements from the array (and any sub-arrays)
    $ArrayHelper->clearArray();

This method simply removes any elements from an array that are 'empty' as defined by the [PHP Empty](http://php.net/empty) method. Use the `output` method to then return the cleaned array.

### splitArray()

This method is used to split your array into equal (or as close to) sections given the number of sections you want. PHP's `array_chunk` requires that you pass in the number of items for each section which isn't always possible. This method automatically works this out for you based on the number of items in the array and the number of sections you require.

    // Split the array into number of sections in equals amounts
    // (Some sections may have extra elements due to remainders)
    $ArrayHelper->splitArray(3);

#### Example

    $ArrayHelper = new \Snscripts\ArrayHelper\ArrayHelper(
        [1, 2, 3, 4, 5, 6, 7]
    );
    $newArray = $ArrayHelper->splitArray(3)
        ->output();

    /* $newArray
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
    ]
    */

### addAfter()

This array allows you to add multiple items to an array at any point based on a element key.

    // Adds the new array element after the given key (where ever it maybe within the array)
    $ArrayHelper->addAfter('b', ['e' => 'Echo']);

#### Example

    $ArrayHelper = new \Snscripts\ArrayHelper\ArrayHelper([
            'a' => 'foo',
            'b' => 'bar'
    ]);
    $newArray = $ArrayHelper
        ->splitArray(
            'a', // after the item with key of 'a'
            [
                'c' => 'test'
            ]
        )
        ->output();

    /* $newArray
    [
        'a' => 'foo',
        'c' => 'test',
        'b' => 'bar'
    ]
    */

### moveItem()

This method allows you to move an item defined by it's element key and move it to after the given element key.

    // Move an item within the array given the element key
    $ArrayHelper->moveItem('e', 'd');

#### Example

    $ArrayHelper = new \Snscripts\ArrayHelper\ArrayHelper([
        'a' => 'alpha',
        'b' => 'bravo',
        'c' => 'charlie'
    ]);
    $newArray = $ArrayHelper
        ->moveItem(
            'b', // move element with key 'b'
            'c' // to after element with key 'c'
        )
        ->output();

    /* $newArray
    [
        'a' => 'alpha',
        'c' => 'charlie',
        'b' => 'bravo'
    ]
    */

### cartesianProduct()

This method will create a cartesian product version of the array by merging all the arrays to create all the possible combinations.

It will be useful in E-Commerce situations when needing to create an array of all possible options of a product based on size / colour or any other product options.

    // Create a cartesian product array
    $ArrayHelper->cartesianProduct();

#### Example

    $ArrayHelper = new \Snscripts\ArrayHelper\ArrayHelper([
        ['S', 'M', 'L'],
        ['Red', 'Blue']
    ]);
    $newArray = $ArrayHelper->cartesianProduct()
        ->output();

    /* $newArray
    [
        ['S', 'Red'],
        ['S', 'Blue'],
        ['M', 'Red'],
        ['M', 'Blue'],
        ['L', 'Red'],
        ['L', 'Blue']
    ]
    */

### getOffsetByKey()

This method returns an integer value of the items position in an array based on it's key, or `null` if it doesn't exist.

This can be useful when using methods such as `array_splice` which require the offset value, with an associative array.

    // Return the offset position of an item where key matches
    $ArrayHelper->getOffsetByKey('b');

#### Example

    $ArrayHelper = new \Snscripts\ArrayHelper\ArrayHelper([
        'a' => 'Alpha',
        'b' => 'Bravo',
        'c' => 'Charlie'
    ]);
    $offset = $ArrayHelper->getOffsetByKey('b');

    // $offset = 1;

#### getOffsetByValue()

This method works as `getOffsetByKey()` only it matches an item and returns it's offset within the array based on the item value.   

    // Return the offset position of an item where value matches
    $ArrayHelper->getOffsetByValue('Charlie');

#### Example

    $ArrayHelper = new \Snscripts\ArrayHelper\ArrayHelper([
        'a' => 'Alpha',
        'b' => 'Bravo',
        'c' => 'Charlie'
    ]);
    $offset = $ArrayHelper->getOffsetByValue('Charlie');

    // $offset = 2;

## Contributing

Please see [CONTRIBUTING](https://github.com/snscripts/array-helper/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/snscripts/array-helper/blob/master/LICENSE) for more information.
