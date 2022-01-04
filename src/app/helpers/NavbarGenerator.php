<?php

namespace app\helpers;

use Yii;
use yii\bootstrap4\Html;

class NavbarGenerator
{
    public static function getCommonItems() : array
    {
        return [
            [
                'label' => Yii::t('menu', 'home'),
                'url' => ['/site/index']
            ]
        ];
    }

    public static function getGuestItems()
    {
        return [
            [
                'label' => Yii::t('menu', 'login'),
                'url' => ['/login']
            ],
            [
                'label' => Yii::t('menu', 'signup'),
                'url' => ['/signup']
            ],
        ];
    }

    public static function getUserItems()
    {
        return  [
            [
                'label' => Yii::t('menu', 'my_postulations'),
                'url' => ['/postulations/my-postulations'],
            ],
            [
                'label' => 'Backoffice',
                'url' =>['/backoffice/index']
            ],
            '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                Yii::t('menu', 'logout') . ' (' . Yii::$app->user->identity->getUsername() . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        ];

    }

    public static function getItems()
    {
        $items = NavbarGenerator::getCommonItems();

        if (Yii::$app->user->isGuest) {
            return array_merge($items, NavbarGenerator::getGuestItems());
        }

        return array_merge($items, NavbarGenerator::getUserItems());

    }
}
