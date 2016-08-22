<?php
namespace Snscripts\ArrayHelper;

class ArrayHelper implements \ArrayAccess, \Iterator
{
    /**
     * Hold the array we are manipulating
     */
    public $array = [];

    /**
     * Load in the array to manipulate
     *
     * @param Array $array
     */
    public function __construct($array)
    {
        $this->help($array);
    }

    /**
     * load in a new array to manipulate
     *
     * @param Array $array
     * @return ArrayHelper $this
     * @throws \InvalidArgumentException
     */
    public function help($array)
    {
        if (! is_array($array)) {
            throw new \InvalidArgumentException('ArrayHelper::Help is expecting an array.');
        }

        $this->array = (array) $array;

        return $this;
    }

    /**
     * return the array
     *
     * @return array $this->array
     */
    public function output()
    {
        return $this->array;
    }

    /**
     * clear an array of any empty elements
     *
     * @return ArrayHelper $this
     */
    public function clearArray()
    {
        $Helper = new ArrayHelper([]);

        foreach ($this->array as $key => $value) {
            if (is_array($value)) {
                $this->array[$key] = $Helper->help($value)
                    ->clearArray()
                    ->output();
            } else {
                if (empty($value)) {
                    unset($this->array[$key]);
                }
            }
        }

        return $this;
    }

    /**
     * take an array and split into the given number of arrays with equal number of elements
     * if an uneven number of elements one (or more) arrays may have more elements then the others
     *
     * @example http://snippi.com/s/9ls9sug
     *
     * @param int The number of sections we want
     * @return ArrayHelper $this
     */
    public function splitArray($sections)
    {
        if (count($this->array) < $sections) {
            $chunkSize = 1;
        } else {
            $chunkSize = ceil(count($this->array) / $sections);
        }

        $this->array = array_chunk($this->array, $chunkSize, true);

        return $this;
    }

    /**
     * Add new elements to the given array after the element with the supplied key
     *
     * @example http://snippi.com/s/6trt9kq
     *
     * @param string|int The key we wish to add our new elements after.
     * @param array The elements we wish to add
     * @return ArrayHelper $this
     */
    public function addAfter($key, $newElements)
    {
        $offset = $this->getOffsetByKey($key);

        if ($offset >= 0) {
            // increment cause we want to actually splice in from the element AFTER the one we found
            $offset++;

            // get the slice, and insert the new elements and rebuild the array
            $arrayItems = array_splice($this->array, $offset);
            $newElements += $arrayItems;
            $this->array += $newElements;
        }

        return $this;
    }

    /**
     * Move Item
     *
     * Moves an existing array item to reposition it after another item.
     *
     * @param string|int The element key we wish to move
     * @param array The element key that'll be before the one we're moving
     * @return ArrayHelper $this
     */
    public function moveItem($key, $moveAfter)
    {
        if (! isset($this->array[$key]) || ! isset($this->array[$moveAfter])) {
            throw new \InvalidArgumentException(
                'ArrayHelper::moveItem("' . $key . '", "' . $moveAfter . '") - One or more of the keys do not exist in the array'
            );
        }

        $moveItem = array(
            $key => $this->array[$key]
        );

        unset($this->array[$key]);

        $this->addAfter($moveAfter, $moveItem);

        return $this;
    }

    /**
     * Produces the cartesian product of all the given arrays
     *
     * @return ArrayHelper $this
     */
    public function cartesianProduct()
    {
        $result = [];
        $arrays = array_values($this->array);
        $sizeIn = count($arrays);
        $size = $sizeIn > 0 ? 1 : 0;
        foreach ($arrays as $array) {
            $size = $size * count($array);
        }

        for ($i = 0; $i < $size; $i ++) {
            $result[$i] = [];

            for ($j = 0; $j < $sizeIn; $j ++) {
                array_push($result[$i], current($arrays[$j]));
            }

            for ($j = ($sizeIn - 1); $j >= 0; $j --) {
                if (next($arrays[$j])) {
                    break;
                } elseif (isset($arrays[$j])) {
                    reset($arrays[$j]);
                }
            }
        }
        $this->array = $result;

        return $this;
    }

    /**
     * get the offset of an element within an array based on the key
     * useful for associative arrays
     *
     * @param array The containing array
     * @param string The key to search for
     * @return int|null The offset within an array | null if not found
     */
    public function getOffsetByKey($needle)
    {
        $offset = 0;

        foreach ($this->array as $key => $value) {
            if ($key === $needle) {
                return $offset;
            }

            $offset++;
        }

        return null;
    }

    /**
     * get the offset of an element within an array based on the element value
     * useful for associative arrays
     *
     * @param string The value to search for
     * @return int|null The offset within an array | null if not found
     */
    public function getOffsetByValue($needle)
    {
        $offset = 0;

        foreach ($this->array as $key => $value) {
            if ($value === $needle) {
                return $offset;
            }

            $offset++;
        }

        return null;
    }

    /**
     * arrayable interface
     *
     * set items to the object as an array $arr['key'] = 'val';
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    /**
     * arrayable interface
     *
     * Support isset / empty around the object isset($arr['key'])
     */
    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    /**
     * arrayable interface
     *
     * Unset an element from the array unset($arr['key']);
     */
    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    /**
     * arrayable interface
     *
     * get an item from the array $arr['key']
     */
    public function offsetGet($offset)
    {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }

    /**
     * iterator interface
     *
     * The following methods allow the object to be treated
     * as an array when looping
     */
    public function rewind()
    {
        return reset($this->array);
    }

    public function current()
    {
        return current($this->array);
    }

    public function key()
    {
        return key($this->array);
    }

    public function next()
    {
        return next($this->array);
    }

    public function valid()
    {
        return key($this->array) !== null;
    }
}
