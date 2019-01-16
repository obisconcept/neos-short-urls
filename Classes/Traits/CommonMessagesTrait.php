<?php
namespace ObisConcept\ShortUrls\Traits;

use Neos\Error\Messages\Message;

trait CommonMessagesTrait
{
    /**
     * Add a success flash message to the queue.
     *
     * @param string $message The message to display
     * @param string $title (optional) A title for the message
     * @param int $code (optional) A custom message code
     * @return void
     */
    protected function addSuccessMessage(string $message, string $title = null, int $code = null)
    {
        $this->addFlashMessage($message, $title, Message::SEVERITY_OK, [], $code ?: 1544708470);
    }

    /**
     * Add a warning flash message to the queue.
     *
     * @param string $message The message to display
     * @param string $title (optional) A title for the message
     * @param int $code (optional) A custom message code
     * @return void
     */
    protected function addWarningMessage(string $message, string $title = null, int $code = null)
    {
        $this->addFlashMessage($message, $title, Message::SEVERITY_WARNING, [], $code ?: 1544708488);
    }

    /**
     * Add an info flash message to the queue.
     *
     * @param string $message The message to display
     * @param string $title (optional) A title for the message
     * @param int $code (optional) A custom message code
     * @return void
     */
    protected function addInfoMessage(string $message, string $title = null, int $code = null)
    {
        $this->addFlashMessage($message, $title, Message::SEVERITY_NOTICE, [], $code ?: 1544708522);
    }

    /**
     * Add an error flash message to the queue.
     *
     * @param string $message The message to display
     * @param string $title (optional) A title for the message
     * @param int $code (optional) A custom message code
     * @return void
     */
    protected function addErrorMessage(string $message, string $title = null, int $code = null)
    {
        $this->addFlashMessage($message, $title, Message::SEVERITY_ERROR, [], $code ?: 1544708539);
    }

    /**
     * Add an exception as error flash message to the queue.
     *
     * @param \Exception $e The exception to handle
     * @return void
     */
    protected function addErrorMessageFromException(\Exception $e)
    {
        $class = get_class($e);
        $this->addErrorMessage($e->getMessage(), "Uncaught $class!", $e->getCode());
    }
}
