<?php

namespace App\EventSubscriber;

use App\Controller\Model\CreatedAtInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class PublicSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof CreatedAtInterface) return;
        $entity->setCreatedAt(new \DateTime());
    }
}
