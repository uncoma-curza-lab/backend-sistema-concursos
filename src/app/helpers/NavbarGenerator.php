<?php

namespace app\helpers;

use app\rbac\helpers\BackofficeRolesAccess;
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
            ],
            [
                'label' => Yii::t('menu', 'help'),
                'url' => ['/site/help']
            ],
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
        $navbarUser = [
            [
                'label' => Yii::t('menu', 'my_postulations'),
                'url' => ['/postulations/my-postulations'],
            ],
        ];
        if (BackofficeRolesAccess::canAccess()) {
            $navbarUser[] = [
                'label' => 'Backoffice',
                'url' =>['/backoffice/index']
            ];
        }
        $navbarUser[] = [
            'label' => Yii::$app->user->identity->getUsername(),
            'items' => [
                [
                    'label' => Yii::t('menu', 'Profile') ,
                    'url' =>['user/profile']
                ],
                [
                    'label' => Yii::t('menu', 'change_password') ,
                    'url' =>['user/change-password']
                ],
                self::getLogout(),
            ],
        ];

        return $navbarUser;

    }

    public static function getItems()
    {
        $items = NavbarGenerator::getCommonItems();

        if (Yii::$app->user->isGuest) {
            return array_merge($items, NavbarGenerator::getGuestItems());
        }

        return array_merge($items, NavbarGenerator::getUserItems());

    }

    private static function getLogout()
    {
        return [
                'label' => Yii::t('menu', 'logout'),
                'url' => '/site/logout',
                'linkOptions' =>  [ 'data-method' => 'post']
        ];
    }
}
