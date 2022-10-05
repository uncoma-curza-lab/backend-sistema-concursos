<?php 

namespace app\events;

use app\models\Contests as Contest;
use app\models\Notification;
use app\models\User;
use yii\base\Event;

class UploadResolutionEvent extends Event implements EventInterface
{
    protected Contest $contest;
    protected string $message;

    public function __construct(Contest $contest){
        $this->message = "El concurso $contest->name tiene una nueva resolución";
        $this->contest = $contest;
        parent::__construct();
    }

    public function handle()
    {
        // TODO: add query Role: Depto docente, quitar el jurado
        foreach ($this->contest->juries as $user) {
            Notification::create($user, $this->message);
        }
    }

}
