<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\Character\PictureUpdatedEvent;
use App\Service\Filesystem\FileRemover;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class RemovedFilesCleaner implements EventSubscriberInterface
{

    public function __construct(private readonly FileRemover $fileRemover) {}

    public static function getSubscribedEvents()
    {
        return [
            PictureUpdatedEvent::class => 'removeCharacterPicture'
        ];
    }

    public function removeCharacterPicture(PictureUpdatedEvent $event): void
    {
        $this->fileRemover->remove($event->oldFilename, '/characters');
    }
}
