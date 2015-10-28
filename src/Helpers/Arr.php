<?php
namespace ir0ny1\Validator\Helpers;

/**
 * Class Arr
 * Array Helpers
 * @package Helpers
 */
class Arr
{
    /**
     * Recursivley go through multidimensional arrays and check for a key
     * Inspired by example found in PHP docs
     * @param array $array
     * @param $key
     * @return bool
     */
    public static function multiKeyExists(array $array, $key)
    {
        // If it is a single level array, check the base for the key
        if (array_key_exists($key, $array)) {
            return true;
        }

        // If it is a multi level array, check the inner array
        foreach ($array as $innerArray) {
            // If this is an inner array, recursivley call this function in the inner array
            if (is_array($innerArray) && self::multiKeyExists($innerArray, $key)) {
                return true;
            }
        }

        // Return false if they key is in neither levels
        return false;
    }

    /**
     * Return Inner value of array
     * @param array $array
     * @param $key string
     * @return null|array
     */
    public static function getInnerValue(array $array, $key)
    {
        foreach ($array as $innerArray) {
            if (is_array($innerArray) && array_key_exists($key, $innerArray)) {
                return $innerArray[$key];
            }
        }
        return null;
    }

    /**
     * Check for inner key in multidimensional array
     * @param array $array
     * @param $key string
     * @return bool
     */
    public static function innerKeyExists(array $array, $key)
    {
        if (array_key_exists($key, $array)) {
            return true;
        }
        foreach ($array as $v) {
            if (!is_array($v)) {
                continue;
            }
            if (array_key_exists($key, $v)) {
                return true;
            }
        }
        return false;
    }
}
