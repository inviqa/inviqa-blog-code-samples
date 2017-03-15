<?php

namespace Inviqa\MessageQueueExample\Api;

use Inviqa\MessageQueueExample\Api\MessageInterface;

interface MessageInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function setMessage($message);

    /**
     * @return string
     */
    public function getMessage();
}