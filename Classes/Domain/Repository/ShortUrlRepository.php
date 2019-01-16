<?php
namespace ObisConcept\ShortUrls\Domain\Repository;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use ObisConcept\ShortUrls\Domain\Model\ShortUrl;
use Neos\Flow\Persistence\QueryResultInterface;

/**
 * @Flow\Scope("singleton")
 */
class ShortUrlRepository extends Repository
{
    public function findAllValid()
    {
        return array_filter($this->findAll()->toArray(), function ($elem) {
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

    public function findOneByLink(string $link)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->equals('link', $link)
        )->execute()->getFirst();
    }

    public function addIdentifierKeysToResult($objects)
    {
        if ($objects instanceof QueryResultInterface) {
            $objects = $objects->toArray();
        } elseif (!is_array($objects)) {
            throw new \InvalidArgumentException(
                'Invalid objects collection given to add identifiers to! Expected a QueryResultInterface or an array.',
                1547659137
            );
        }

        $result = [];

        foreach ($objects as $obj) {
            $result[$this->persistenceManager->getIdentifierByObject($obj)] = $obj;
        }

        return $result;
    }
}
