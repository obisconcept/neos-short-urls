<?php
namespace ObisConcept\ShortUrls\Controller;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use ObisConcept\ShortUrls\Domain\Service\ShortIdService;

/**
 * @Flow\Scope("singleton")
 */
class StandardController extends ActionController
{
    /**
     * @Flow\Inject
     * @var ShortIdService
     */
    protected $idGenerator;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('foos', array(
            'bar', 'baz'
        ));
    }
}
