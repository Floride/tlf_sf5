<?php
// src\EventListener\userPictureListener.php
namespace App\EventListener;

use Vich\UploaderBundle\Event\Event;

class userPictureListener
{
    public function onVichUploaderPreUpload(Event $event)
    {
        $object = $event->getObject();
        $mapping = $event->getMapping();
        
        //dump($event);
        // do your stuff with $object and/or $mapping...
    }
}
