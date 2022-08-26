<?php

namespace app\models;

use Yii;

class PostulationStatus
{
    const DRAFT = 'draft';
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const STATUSES = [self::DRAFT, self::PENDING, self::ACCEPTED, self::REJECTED];

    public static function getTranslation(string $status) : string
    {
        return Yii::t('models/postulation-status', $status);
    }

    public static function isEqualStatus(string $compareStatus, string $equlaToStatus) : bool
    {
        if(!self::isValidStauts($equlaToStatus)){
            throw new \Exception("Error: The param $equlaToStatus is not a valid Postulation Status");
        }

        return $compareStatus == $equlaToStatus;
    }

    private static function isValidStauts(string $status) : bool
    {
        return in_array($status, self::STATUSES);
    }
}
