<?php
namespace ObisConcept\ShortUrls\Domain\Model;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;
use Neos\Neos\Domain\Model\User;
use Neos\Neos\Domain\Service\UserService;
use Neos\Flow\Core\Bootstrap;

/**
 * @Flow\Entity
 */
class ShortUrl
{
    /**
     * @Flow\Validate(type="NotEmpty")
     * @var string
     */
    protected $name;

    /**
     * @Flow\Validate(type="NotEmpty")
     * @var string
     */
    protected $link;

    /**
     * @Flow\Validate(type="NotEmpty")
     * @var string
     */
    protected $target;

    /**
     * @Flow\Validate(type="NotEmpty")
     * @ORM\ManyToOne
     * @var \Neos\Neos\Domain\Model\User
     */
    protected $creator;

    /**
     * @Flow\Validate(type="NotEmpty")
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * @ORM\Column(nullable=true)
     * @var \DateTime
     */
    protected $validFrom;

    /**
     * @ORM\Column(nullable=true)
     * @var \DateTime
     */
    protected $validUntil;

    /**
     * @param string $name
     * @param string $link
     * @param string $target
     * @param \DateTime $validFrom
     * @param \DateTime $validUntil
     */
    public function __construct(
        string $name,
        string $link,
        string $target,
        User $creator = null,
        \DateTime $validFrom = null,
        \DateTime $validUntil = null
    ) {
        $this->name = $name;
        $this->link = $link;
        $this->target = $target;
        $this->validFrom = $validFrom;
        $this->validUntil = $validUntil;

        $userService = (Bootstrap::$staticObjectManager)->get(UserService::class);

        $this->creator = $userService->getCurrentUser();
        $this->creationDate = new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }
    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }
    /**
     * @return \Neos\Neos\Domain\Model\User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param \Neos\Neos\Domain\Model\User $creator
     * @return void
     */
    public function setCreator(\Neos\Neos\Domain\Model\User $creator)
    {
        $this->creator = $creator;
    }
    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     * @return void
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }
    /**
     * @return \DateTime
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * @param \DateTime $validFrom
     * @return void
     */
    public function setValidFrom(\DateTime $validFrom)
    {
        $this->validFrom = $validFrom;
    }
    /**
     * @return \DateTime
     */
    public function getValidUntil()
    {
        return $this->validUntil;
    }

    /**
     * @param \DateTime $validUntil
     * @return void
     */
    public function setValidUntil(\DateTime $validUntil)
    {
        $this->validUntil = $validUntil;
    }
}
