<?php

namespace Inviqa\MessageQueueExample\Api;

use Inviqa\MessageQueueExample\Api\MessageInterface;

interface SubscriberInterface
{
    /**
     * @return void
     */
    public function processMessage(MessageInterface $message);
}