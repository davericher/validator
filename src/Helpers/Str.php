<?php
namespace ir0ny1\Validator\Helpers;

/**
 * Class Str
 * String Helpers
 * @package Helpers
 */
class Str
{
    /**
     * Convert camel to title case
     * Example helloWorld becomes Hello World
     * @param $input string
     * @return string
     */
    public static function camelToTitleCase($input)
    {
        return ucwords(self::convertCamelCase($input));
    }

    /**
     * Convert camel to regular case
     * Example: helloWorld becomes hello world
     * From: https://gist.github.com/justjkk/1402061
     * @param $input string
     * @return string
     */
    public static function camelToRegularCase($input)
    {
        return strtolower(self::convertCamelCase($input));
    }

    public static function convertCamelCase($input)
    {
        $intermediate = preg_replace('/(?!^)([[:upper:]][[:lower:]]+)/', ' $0', $input);
        $titleStr = preg_replace('/(?!^)([[:lower:]])([[:upper:]])/', '$1 $2', $intermediate);
        return $titleStr;
    }
}
