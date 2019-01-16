<?php
namespace ObisConcept\ShortUrls\Controller;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use ObisConcept\ShortUrls\Domain\Service\ShortIdService;
use ObisConcept\ShortUrls\Domain\Service\ShortUrlFactory;

/**
 * @Flow\Scope("singleton")
 */
class ShortUrlController extends ActionController
{
    /**
     * @Flow\Inject
     * @var ShortIdService
     */
    protected $idGenerator;

    /**
     * @Flow\Inject
     * @var ShortUrlFactory
     */
    protected $factory;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('shortLinks', []);
    }
}
