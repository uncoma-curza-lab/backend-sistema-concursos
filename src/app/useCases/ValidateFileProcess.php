<?php 
namespace app\useCases;

use app\models\PersonalFile;
use app\modules\backoffice\models\PersonalFileValidationForm;
use Exception;
use InvalidArgumentException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ValidateFileProcess
{
    protected $form;

    public function __construct(PersonalFileValidationForm $form) {
        $this->form = $form;
    }

    public function handle()
    {
        //TODO: Translations
        if(!$this->form->validate()){
            throw new InvalidArgumentException();
        }
        if (
            !\Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'validateFiles')
        ){
            throw new ForbiddenHttpException('Usted no tiene permisos para realizar esta acción');
        }

        $file = PersonalFile::findOne($this->form->fileId);
        if(!$file){
            throw new NotFoundHttpException('Archivo No encontrado');
        }

        if(!$this->save($file)) {
            throw new Exception('Error al Guardar');
        }
    }

    private function save(PersonalFile $file)
    {
        $file->is_valid = $this->form->idValid;
        $file->valid_until = $this->form->expireDate;
        return $file->update();
    }

    
}

