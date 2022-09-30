<?php 
namespace app\events;

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
}
