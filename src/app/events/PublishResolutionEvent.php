<?php 

namespace app\events;

use app\models\Contests as Contest;
use app\models\Notification;
use yii\base\Event;

class PublishResolutionEvent extends Event implements EventInterface
{
    protected Contest $contest;
    protected string $message;

    public function __construct(Contest $contest){
        $this->message = "El concurso .... fue publicado .....";
        $this->contest = $contest;
        parent::__construct();
    }

    public function handle()
    {
        foreach ($this->contest->postulations as $user) {
            $this->saveNotification($user->id);
        }
    }

    /**
     * @deprecated
     */
    public function sendNotification(string $messege)
    {
        $this->setMessege($messege);
        //$this->saveNotification();
    }
    
    public function setMessege(string $messege)
    {
        $this->message = $messege;
    }

    protected function saveNotification($user)
    {
        $notification = new Notification();
        $notification->user_to = $user;
        $notification->message = $this->message;
        $notification->timestamp = date('Y-m-d h:m:s');

        return $notification->save();

    }
}
