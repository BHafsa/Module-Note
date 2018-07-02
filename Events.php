<?php

namespace humhub\modules\note;

use Yii;
use yii\helpers\Url;

class Events extends \yii\base\Object
{

    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Note",
            'icon' => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
            'url' => Url::to(['/note/etudiant']),// a remplacer par le teste
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'Note' && Yii::$app->controller->id == 'etudiant'),
        ));
    }


    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Note",
            'url' => Url::to(['/note/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'Note' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ));
    }

}

