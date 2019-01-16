<?php
namespace ObisConcept\ShortUrls\Domain\Service;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class DateTimeService
{
    public static function resetTime(\DateTime $dateTime)
    {
        return ($dateTime->setTime(0, 0, 0));
    }
}
