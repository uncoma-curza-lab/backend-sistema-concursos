<?php

namespace app\models;

use Yii;

class PostulationStatus
{
    const DRAFT = 'draft';
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';

    public static function getTranslation(string $status) : string
    {
        return Yii::t('models/postulation-status', $status);
    }
}
