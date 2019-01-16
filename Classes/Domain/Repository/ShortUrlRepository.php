<?php
namespace ObisConcept\ShortUrls\Domain\Repository;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use ObisConcept\ShortUrls\Domain\Model\ShortUrl;

/**
 * @Flow\Scope("singleton")
 */
class ShortUrlRepository extends Repository
{
    public function findAll()
    {
        return (parent::findAll())->toArray();
    }

    public function findAllValid()
    {
        return array_filter($this->findAll(), function ($elem) {
            $now = new \DateTime('now');
            $validUntil = $elem->getValidUntil();
            $validFrom = $elem->getValidFrom();

            return ((
                $validUntil === null ||
                ($validFrom !== null && $validUntil > $now && $validFrom < $now) ||
                $validUntil < $now
            ));
        });
    }

    public function findOneByTarget(string $target)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->equals('target', $target)
        )->execute()->getFirst();
    }

    public function addIdentifierKeysToResult(array $objects)
    {
        $result = [];

        foreach ($objects as $obj) {
            $result[$this->persistenceManager->getIdentifierByObject($obj)] = $obj;
        }

        return $result;
    }
}
