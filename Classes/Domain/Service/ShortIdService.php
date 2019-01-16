<?php
namespace ObisConcept\ShortUrls\Domain\Service;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

use Hidehalo\Nanoid\Client;
use ObisConcept\ShortUrls\Traits\BitwiseOperationsTrait;
use ObisConcept\ShortUrls\Exception\InvalidPatternException;

/**
 * A generator service for short ids.
 */
class ShortIdService
{
    use BitwiseOperationsTrait;

    const DEFAULT_ID_LENGTH = 7;
    
    const REQUIRED_ID_LENGTH = 5;
    const REQUIRED_PATTERN_LENGTH = self::REQUIRED_ID_LENGTH * 2;

    const MAX_ID_LENGTH = 100;
    const MAX_PATTERN_LENGTH = self::MAX_ID_LENGTH * 2;
    
    const TYPE_CUSTOM = -1;
    const TYPE_DEFAULT = 0;

    const TYPE_NUMBERS = 1;
    const TYPE_LETTERS_SMALL = 2;
    const TYPE_LETTERS_LARGE = 4;
    const TYPE_SPECIAL_CHARS = 8;

    const PATTERN_DEFAULT = self::PATTERN_NUMBERS . self::PATTERN_LETTERS_LARGE . self::PATTERN_LETTERS_SMALL . self::PATTERN_SPECIAL_CHARS;
    const PATTERN_NUMBERS = '0123456789';
    const PATTERN_LETTERS_SMALL = 'abcdefghijklmnopqrstuvwxyz';
    const PATTERN_LETTERS_LARGE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const PATTERN_SPECIAL_CHARS = '_-';

    /**
     * @var Client
     */
    protected $client;

    public function initializeObject()
    {
        $this->client = new Client;
    }

    /**
     * Generate a simple shortId.
     *
     * @param int $length The desired length of the identifier.
     * @return string
     */
    public function generateSimpleId(int $length = self::DEFAULT_ID_LENGTH)
    {
        return $this->client->generateId($length);
    }

    /**
     * Generate a complex shortid.
     *
     * @param int $length The desired length of the identifier.
     * @param int $type The type of the pattern to use for generation.
     *                  This has to be a bitmask of TYPE_NUMBERS, TYPE_LETTERS_SMALL, TYPE_LETTERS_LARGE, TYPE_SPECIAL_CHARS
     *                  or one of the following values: TYPE_DEFAULT, TYPE_CUSTOM.
     * @param string $pattern Used as generator pattern when TYPE_CUSTOM is specified.
     * @return string
     * @throws InvalidPatternException
     */
    public function generateIdentifier(int $length = self::DEFAULT_ID_LENGTH, int $type = self::TYPE_DEFAULT, string $pattern = self::PATTERN_DEFAULT)
    {
        if ($type !== self::TYPE_DEFAULT && $type !== self::TYPE_CUSTOM) {
            $pattern = $this->retrievePattern($type);
        }

        return $this->client->formatedId($pattern, $length);
    }

    /**
     * Retrieve the pattern for the given type.
     *
     * @param int $type The type to resolve.
     * @return string
     * @throws InvalidPatternException
     */
    protected function retrievePattern(int $type = TYPE_DEFAULT)
    {
        if ($type === self::TYPE_DEFAULT) {
            return self::PATTERN_DEFAULT;
        }

        $pattern = '';

        if ($this->isFlagSet(self::TYPE_NUMBERS)) {
            $pattern .= self::PATTERN_NUMBERS;
        }

        if ($this->isFlagSet(self::TYPE_LETTERS_LARGE)) {
            $pattern .= self::PATTERN_LETTERS_LARGE;
        }

        if ($this->isFlagSet(self::TYPE_LETTERS_SMALL)) {
            $pattern .= self::PATTERN_LETTERS_SMALL;
        }

        if ($this->isFlagSet(self::TYPE_SPECIAL_CHARS)) {
            $pattern .= self::PATTERN_SPECIAL_CHARS;
        }

        if (empty($pattern)) {
            throw InvalidPatternException::forEmpty();
        } elseif (($length = strlen($pattern)) < self::REQUIRED_PATTERN_LENGTH) {
            throw InvalidPatternException::forInvalidLength($length, self::REQUIRED_PATTERN_LENGTH);
        } elseif ($length > self::MAX_PATTERN_LENGTH) {
            throw InvalidPatternException::forInvalidLength($length, self::MAX_PATTERN_LENGTH);
        }

        return $pattern;
    }
}
