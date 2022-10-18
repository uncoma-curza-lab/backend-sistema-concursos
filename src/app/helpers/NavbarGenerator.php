<?php

namespace app\helpers;

use app\models\Notification;
use app\rbac\helpers\BackofficeRolesAccess;
use Yii;
use yii\helpers\Html;

class NavbarGenerator
{
    public static function getCommonItems() : array
    {
        return [
            [
                'label' => Yii::t('menu', 'home'),
                'url' => ['/site/index'],
                'options' => ['class' => 'd-flex align-items-center']
            ],
            [
                'label' => Yii::t('menu', 'help'),
                'url' => ['/site/help'],
                'options' => ['class' => 'd-flex align-items-center']
            ],
        ];
    }

    public static function getGuestItems()
    {
        return [
            [
                'label' => Yii::t('menu', 'login'),
                'url' => ['/login'],
                'options' => ['class' => 'd-flex align-items-center']
            ],
            [
                'label' => Yii::t('menu', 'signup'),
                'url' => ['/signup'],
                'options' => ['class' => 'd-flex align-items-center']
            ],
        ];
    }

    public static function getUserItems()
    {
        $navbarUser = [
            [
                'label' => Yii::t('menu', 'my_postulations'),
                'url' => ['/postulations/my-postulations'],
                'options' => ['class' => 'd-flex align-items-center']
            ],
         ];
        if (BackofficeRolesAccess::canAccess()) {
            $navbarUser[] = [
                'label' => 'Backoffice',
                'url' =>['/backoffice/index'],
                'options' => ['class' => 'd-flex align-items-center']
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
                'options' => ['class' => 'd-flex align-items-center']
        ];
        $notificationsCount = Notification::find()->countUnreadSessionUser();
        $showCount = $notificationsCount ? Html::tag('span', $notificationsCount,['class' => 'badge badge-info']) : '';

         $navbarUser[] = [
             'label' => Html::tag('i','' ,['class' => 'nav-icon bi bi-bell']) . $showCount,
                'url' => ['/notifications'],
                'options' => ['class' => 'd-flex align-items-center']
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
