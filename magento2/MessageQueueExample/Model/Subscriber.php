<?php

namespace Inviqa\MessageQueueExample\Model;

use Magento\Framework\Model\AbstractModel;
use Inviqa\MessageQueueExample\Api\MessageInterface;
use Inviqa\MessageQueueExample\Api\SubscriberInterface;

class Subscriber implements SubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public function processMessage(MessageInterface $message)
    {
        echo 'Message received: ' . $message->getMessage() . PHP_EOL;
    }
}