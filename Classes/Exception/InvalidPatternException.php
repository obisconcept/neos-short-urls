<?php
namespace ObisConcept\ShortUrls\Exception;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

class InvalidPatternException extends \Neos\Flow\Exception
{
    public static function forPattern(string $pattern)
    {
        return new self("Invalid generator pattern string given: '$pattern'!", 1547640616);
    }

    public static function forEmpty()
    {
        return new self("Generator pattern may not be left empty!", 1547640656);
    }

    public static function forInvalidLength(int $actual, int $expected)
    {
        if ($expected < $actual) {
            return new self("Generator pattern is too long! Excepted $expected characters maximum, recieved $actual.", 1547641084);
        } elseif ($expected > $actual) {
            return new self("Generator pattern is too short! Expected $expected characters at least, recieved $actual.", 1547640988);
        }

        return new self("Generator pattern has an invalid length: $actual!", 1547641114);
    }
}
