<?php
// src\EventListener\userPictureListener.php
namespace App\EventListener;

use Vich\UploaderBundle\Event\Event;

/**
 * Class class userPictureListener
 *
 * PHP version 7.2.5
 *
 * @package    App\EventListener
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class userPictureListener
{
    public function onVichUploaderPreUpload(Event $event)
    {
        $object = $event->getObject();
        $mapping = $event->getMapping();
        
        dump($object, $mapping);
    }
}
