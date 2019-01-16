<?php
namespace ObisConcept\ShortUrls\Controller;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use ObisConcept\ShortUrls\Domain\Service\ShortIdService;
use ObisConcept\ShortUrls\Domain\Service\ShortUrlFactory;
use ObisConcept\ShortUrls\Domain\Repository\ShortUrlRepository;
use ObisConcept\ShortUrls\Domain\Model\ShortUrl;
use ObisConcept\ShortUrls\Traits\CommonMessagesTrait;

/**
 * @Flow\Scope("singleton")
 */
class ShortUrlController extends ActionController
{
    use CommonMessagesTrait;

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
     * @Flow\Inject
     * @var ShortUrlRepository
     */
    protected $shortUrlRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $shortLinks = $this->shortUrlRepository->findAll();
        $shortLinks = $this->shortUrlRepository->addIdentifierKeysToResult($shortLinks);

        $this->view->assign('shortLinks', $shortLinks);
    }

    /**
     * @return void
     */
    public function newAction()
    {
        $randomId = $this->idGenerator->generateSimpleId();

        $this->view->assign('randId', $randomId);
    }

    /**
     * @return void
     */
    public function newTimedAction()
    {
        $randomId = $this->idGenerator->generateSimpleId();

        $this->view->assign('randId', $randomId);
    }

    /**
     * @param ShortUrl $shortUrl
     * @return void
     */
    public function createAction(ShortUrl $shortUrl)
    {
        if ($this->validateRequestMethod()) {
            $link = $shortUrl->getLink();

            if ($this->shortUrlRepository->findOneByLink($link) !== null) {
                $this->addWarningMessage("A short url with the link '$link' already exists!");
                $this->redirect('index');
                return;
            }

            $name = $shortUrl->getName();

            $this->shortUrlRepository->add($shortUrl);

            $this->addSuccessMessage("Successfully created the new short url '$name'.");
            $this->redirect('index');
        }
    }

    /**
     * @param string $identifier
     * @return void
     */
    public function editAction(string $identifier)
    {
        $shortUrl = $this->shortUrlRepository->findByIdentifier($identifier);

        $this->view->assign('shortUrl', $shortUrl);
        $this->view->assign('isTimed', ($shortUrl->getValidUntil() !== null));
    }

    /**
     * @param ShortUrl $shortUrl
     * @return void
     */
    public function updateAction(ShortUrl $shortUrl)
    {
        if ($this->validateRequestMethod()) {
            $name = $shortUrl->getName();

            $this->shortUrlRepository->update($shortUrl);

            $this->addSuccessMessage("Successfully updated the short url '$name'.");
            $this->redirect('index');
        }
    }

    /**
     * @param ShortUrl $shortUrl
     * @return void
     */
    public function deleteAction(ShortUrl $shortUrl)
    {
        if ($this->validateRequestMethod()) {
            $name = $shortUrl->getName();

            $this->shortUrlRepository->add($shortUrl);

            $this->addSuccessMessage("Successfully deleted the short url '$name'.");
            $this->redirect('index');
        }
    }

    /**
     * Validates that the current action request is of a specific method.
     *
     * @param string $expected The expected request method (defaults to 'POST')
     * @return bool
     */
    protected function validateRequestMethod(string $expected = 'POST')
    {
        $method = $this->request->getHttpRequest()->getMethod();

        if ($method === $expected) {
            return true;
        }

        $action = $this->request->getControllerActionName();

        $this->addErrorMessage("Invalid request method for action '$action', expected '$expected' but recieved '$method'!");
        $this->redirect('index');

        return false;
    }

    public function redirectToTargetAction(string $id)
    {
        $shortUrl = $this->shortUrlRepository->findOneByLink($id);

        if ($shortUrl === null) {
            throw new \InvalidArgumentException(
                "Could not locate any short url for the given identifier '$id'!",
                1547661334
            );
        }

        $this->redirectToUri($shortUrl->getTarget(), 0, 303);
    }
}
