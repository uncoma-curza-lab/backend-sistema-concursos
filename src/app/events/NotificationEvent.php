<?php 
namespace app\events;

use app\models\Notification;
use yii\base\Event;

class NotificationEvent extends Event 
{
    protected $userReceiver;
    protected $message;

    public function __construct($userReceiver){
        $this->userReceiver = $userReceiver;
        $message = "";
        parent::__construct();
    }

    public function sendNotification(string $messege)
    {
        $this->setMessege($messege);
        $this->saveNotification();
    }
    
    public function setMessege(string $messege)
    {
        $this->message = $messege;
    }

    protected function saveNotification()
    {
        $notification = new Notification();
        $notification->user_to = $this->userReceiver;
        $notification->message = $this->message;
        $notification->timestamp = date('Y-m-d h:m:s');

        return $notification->save();

    }
}
