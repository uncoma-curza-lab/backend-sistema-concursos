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
    protected string $url;

    public function __construct(Contest $contest){
        $this->message = "El concurso $contest->name tiene una nueva resolución";
        $this->url = "/backoffice/contest/download-resolution/$contest->code";
        $this->contest = $contest;
        parent::__construct();
    }

    public function handle()
    {
        $users = User::find()->getAllByRol('teach_departament');
        foreach ($users as $user) {
            Notification::create($user, $this->message, $this->url);
        }
    }

}
