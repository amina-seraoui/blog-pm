<?php

namespace App\EventSubscriber;

use App\Controller\Model\CreatedAtInterface;
use App\Controller\Model\UpdatedAtInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setEntityCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setEntityUpdatedAt']
        ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $e)
    {
        $entity = $e->getEntityInstance();
        if (!$entity instanceof CreatedAtInterface) return;

        $entity->setCreatedAt(new \DateTime());
    }

    public function setEntityUpdatedAt(BeforeEntityUpdatedEvent $e)
    {
        $entity = $e->getEntityInstance();
        if (!$entity instanceof UpdatedAtInterface) return;

        $entity->setUpdatedAt(new \DateTime());
    }
}
