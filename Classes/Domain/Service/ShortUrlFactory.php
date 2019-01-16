<?php
namespace ObisConcept\ShortUrls\Domain\Service;

use ObisConcept\ShortUrls\Domain\Model\ShortUrl;
use Neos\Neos\Domain\Service\UserService;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

class ShortUrlFactory
{
    /**
     * @Flow\Inject
     * @var ShortIdService
     */
    protected $idGenerator;

    /**
     * @Flow\Inject
     * @var UserService
     */
    protected $userService;

    /**
     * Create a new short url intance.
     *
     * @param string $name
     * @param string $target
     * @param string|null $link
     * @return ShortUrl
     */
    public function create(
        string $name,
        string $target,
        string $link = null,
        \DateTime $from = null,
        \DateTime $until = null
    ) : ShortUrl {
        if ($link === null) {
            $link = $this->idGenerator->generateSimpleId();
        }

        $shortUrl = new ShortUrl($name, $link, $target, $this->userService->getCurrentUser());

        if ($from !== null) {
            $shortUrl->setValidFrom($from);
        }

        if ($until !== null) {
            $shortUrl->setValidUntil($until);
        }

        return $shortUrl;
    }
}
