<?php
use humhub\components\console\Application;
use humhub\modules\note\Events;

return [
    'id' => 'note',
    'class' => 'humhub\modules\note\Module',
    'namespace' => 'humhub\modules\note',
    'events' => [
        [
            'class' => \humhub\widgets\TopMenu::className(),
            'event' => \humhub\widgets\TopMenu::EVENT_INIT,
            'callback' => ['humhub\modules\note\Events', 'onTopMenuInit'],
        ],
        [
            'class' => humhub\modules\admin\widgets\AdminMenu::className(),
            'event' => humhub\modules\admin\widgets\AdminMenu::EVENT_INIT,
            'callback' => ['humhub\modules\note\Events', 'onAdminMenuInit']
        ],
        [
            'class' => Application::class,
            'event' => Application::EVENT_ON_INIT,
            'callback' => [Events::class, 'onConsoleApplicationInit',]
        ]
    ],
];
