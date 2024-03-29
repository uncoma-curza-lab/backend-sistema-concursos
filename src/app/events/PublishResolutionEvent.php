<?php 

namespace app\events;

use app\models\Contests as Contest;
use app\models\Notification;
use yii\base\Event;

class PublishResolutionEvent extends Event implements EventInterface
{
    protected Contest $contest;
    protected string $message;
    protected string $url;

    public function __construct(Contest $contest){
        $this->message = "El concurso $contest->name a finalizado y publicado el dictamen.";
        $this->url = "/postulations/download-resolution/$contest->code";
        $this->contest = $contest;
        parent::__construct();
    }

    public function handle()
    {
        $users = [];
        $juries = [];
        $postulats = [];

        foreach ($this->contest->postulations as $postulation) {
            if($postulation->status == 'accepted'){
                array_push($postulats, $postulation->person->user);
            }
        }
        
        foreach ($this->contest->contestJuriesRelationship as $jury) {
            if($jury->is_president){
                array_push($juries, $jury->user);
            }
        }

        $users = array_merge($postulats, $juries);

        Notification::batchCreate($users, $this->message, $this->url);
    }
}
