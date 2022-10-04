<?php 
namespace app\components;

use app\events\NotificationEvent;
use yii\base\Component;

class NotifiactionComponent extends Component
{
    public function publishResolution($users)
    {
        foreach ($users as $user) {
            $event = new NotificationEvent($user->id);
            $event->on($event->className(), 'publishResolution', $event->sendNotification('Resolution PUblished'));
            $event->trigger($event->className(), 'publishResolution', $event);
        }
    }

}
?>
