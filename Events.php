<?php

namespace humhub\modules\note;

use Yii;
use yii\base\Object;
use yii\helpers\Url;
use  humhub\modules\note\permissions\ViewNote;

class Events extends Object
{

    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        if(\Yii::$app->user->getPermissionManager()->can(new ViewNote())){
            $event->sender->addItem([
                'label' => 'Note',
                'icon' => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
                'url' => Url::to(['/note/student']),
                'sortOrder' => 99999,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'note' && Yii::$app->controller->id == 'student'),
                
            ]);
        }
    }
    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        if(\Yii::$app->user->getPermissionManager()->can(new ViewNote())){
            $event->sender->addItem([
                'label' => 'Note',
                'url' => Url::to(['/note/admin']),
                'group' => 'manage',
                'icon' => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'note' && Yii::$app->controller->id == 'admin'),
                'sortOrder' => 99999,
            ]);
        }
    }

    public static function onConsoleApplicationInit($event)
    {
        if(\Yii::$app->user->getPermissionManager()->can(new ViewNote())){
            $application = $event->sender;
            $application->controllerMap['note'] = commands\NoteController::class;
        }
     
    }
}
