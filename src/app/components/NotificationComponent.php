<?php 
namespace app\components;

use app\events\NotificationEvent;
use yii\base\Component;

class NotificationComponent extends Component
{
    public function publishResolution($users)
    {
        foreach ($users as $user) {
            $event = new NotificationEvent($user->id);
            $this->on($event->className(), 'publishResolution', $event->sendNotification('Resolution PUblished'));
            $this->trigger('publishResolution', $event);
        }
    }

}
