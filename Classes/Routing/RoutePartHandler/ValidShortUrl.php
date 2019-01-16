<?php
namespace ObisConcept\ShortUrls\Routing\RoutePartHandler;

/*
 * This file is part of the Concept.Toolbox package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Configuration\Exception\InvalidConfigurationException;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Mvc\Routing\DynamicRoutePart;
use ObisConcept\ShortUrls\Domain\Repository\ShortUrlRepository;

class ValidShortUrl extends DynamicRoutePart
{
    /**
     * @var ShortUrlRepository
     */
    protected $shortUrlRepository;

    public function __construct()
    {
        $objectManager = Bootstrap::$staticObjectManager;

        $this->shortUrlRepository = $objectManager->get(ShortUrlRepository::class);
    }

    /**
     * @inheritDoc
     */
    protected function resolveValue($value)
    {
        return $this->isValid($value);
    }

    /**
     * @inheritDoc
     */
    protected function matchValue($value)
    {
        return $this->isValid($value);
    }

    protected function isValid($value)
    {
        $shortUrls = $this->shortUrlRepository->findAllValid();

        foreach ($shortUrls as $shortUrl) {
            if ($shortUrl->getLink() === $value) {
                $this->value = $value;
                return true;
            }
        }

        return false;
    }
}
