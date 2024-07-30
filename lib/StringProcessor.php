<?php

declare(strict_types=1);

namespace FuzzyWuzzy;

/**
 * Convenience methods for working with string values.
 *
 * @author Michael Crumm <mike@crumm.net>
 */
class StringProcessor
{
    public static function nonAlnumToWhitespace(string $str): string
    {
        return preg_replace('/(?i)\W/u', ' ', $str);
    }

    public static function upcase(string $str): string
    {
        return strtoupper($str);
    }

    public static function downcase(string $str): string
    {
        return strtolower($str);
    }

    public static function join(array $pieces, string $glue = ' '): string
    {
        return Collection::coerce($pieces)->join($glue);
    }

    public static function split(string $str, string $delimiter = ' '): Collection
    {
        return new Collection(explode($delimiter, $str));
    }

    public static function strip(string $str, string $chars = " \t\n\r\0\x0B"): string
    {
        return trim($str, $chars);
    }
}
