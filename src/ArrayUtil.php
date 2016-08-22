<?php

use Snscripts\ArrayHelper\ArrayHelper;

class ArrayUtil
{
    /**
     * clear an array of any empty elements
     *
     * @param   array   Array to clear
     * @return  array   Clean array
     */
    public static function clearArray($array)
    {
        $ArrayHelper = new ArrayHelper($array);
        $ArrayHelper->clearArray();

        return $ArrayHelper->output();
    }

    /**
     * take an array and split into the given number of arrays with equal number of elements
     * if an uneven number of elements one (or more) arrays may have more elements then the others
     *
     * @example http://snippi.com/s/9ls9sug
     *
     * @param array The array we want to split
     * @param int The number of sections we want
     * @return array The resulting split array
     */
    public static function splitArray($array, $sections)
    {
        $ArrayHelper = new ArrayHelper($array);
        $ArrayHelper->splitArray($sections);

        return $ArrayHelper->output();
    }

    /**
     * Add new elements to the given array after the element with the supplied key
     *
     * @example http://snippi.com/s/6trt9kq
     *
     * @param array The array we want to add to
     * @param string|int The key we wish to add our new elements after.
     * @param array The elements we wish to add
     * @return array The resulting array with new elements
     */
    public static function addAfter($array, $key, $newElements)
    {
        $ArrayHelper = new ArrayHelper($array);
        $ArrayHelper->addAfter($key, $newElements);

        return $ArrayHelper->output();
    }

    /**
     * get the offset of an element within an array based on the key
     * useful for associative arrays
     *
     * @param array The containing array
     * @param string The key to search for
     * @return int|null The offset within an array | null if not found
     */
    public static function getOffsetByKey($array, $needle)
    {
        $ArrayHelper = new ArrayHelper($array);
        return $ArrayHelper->getOffsetByKey($needle);
    }

    /**
     * get the offset of an element within an array based on the element value
     * useful for associative arrays
     *
     * @param array The containing array
     * @param string The value to search for
     * @return int|null The offset within an array | null if not found
     */
    public static function getOffsetByValue($array, $needle)
    {
        $ArrayHelper = new ArrayHelper($array);
        return $ArrayHelper->getOffsetByValue($needle);
    }

    /**
     * Move Item
     *
     * Moves an existing array item to reposition it after another item.
     *
     * @param array The array we want to do the reordering in
     * @param string|int The element key we wish to move
     * @param array The element key that'll be before the one we're moving
     * @return array The resulting array with reordered elements
     */
    public static function moveItem($array, $key, $moveAfter)
    {
        $ArrayHelper = new ArrayHelper($array);
        $ArrayHelper->moveItem($key, $moveAfter);

        return $ArrayHelper->output();
    }

    /**
     * Produces the cartesian product of all the given arrays
     *
     * @param array Array of Arrays to combine e.g. array( array('a', 'b'), array('1', '2') )
     * @return array Array of products e.g. array( array('a', '1'), array('a', '2'), array('b', '1'), array('b', '2'))
     */
    public static function cartesianProduct($array)
    {
        $ArrayHelper = new ArrayHelper($array);
        $ArrayHelper->cartesianProduct();

        return $ArrayHelper->output();
    }
}
