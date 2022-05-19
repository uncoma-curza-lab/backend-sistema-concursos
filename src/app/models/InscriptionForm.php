<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class InscriptionForm extends Model
{
    public $accepted_term_article22;
    public $confirm_data;
    public $contest;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['accepted_term_article22', 'confirm_data'],
                'required',
                'requiredValue' => true,
                'message' => 'Debe aceptar los términos para continuar'
            ],
            [['accepted_term_article22', 'confirm_data'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'accepted_term_article22' => \Yii::t('app', 'terms_accepted_article_22'),
            'confirm_data' => \Yii::t('app', 'confirm_data'),
        ];
    }

    public function save()
    {
        if (!$this->contest->canPostulate()) {
            return false;
        }
        $postulations = new Postulations();
        $postulations->contest_id = $this->contest->id;
        $postulations->person_id = Yii::$app->user->identity->person->id;
        $postulations->accepted_term_article22 = $this->accepted_term_article22;
        $postulations->confirm_data = $this->confirm_data;
        $postulations->status = PostulationStatus::PENDING;
        if($postulations->createPostulationFolder()){
            $share = $postulations->createPostulationFolderShare(4, '2022-05-20');
            var_dump($share);
            if($share['code'] == 100){
                $postulations->shere_id = 22; // $share['data']['id'];
                return $postulations->save();
            }else{
            var_dump($share);
                return false;
            }
        }else{
            return false;
        }
    }
}
