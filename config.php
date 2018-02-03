<?php
return [
	'id' => 'Note',
	'class' => 'humhub\modules\Note\Module',
	'namespace' => 'humhub\modules\Note',
	'events' => [
		[
			'class' => \humhub\widgets\TopMenu::className(),
			'event' => \humhub\widgets\TopMenu::EVENT_INIT,
			'callback' => ['humhub\modules\Note\Events', 'onTopMenuInit'],
		],
		[
			'class' => humhub\modules\admin\widgets\AdminMenu::className(),
			'event' => humhub\modules\admin\widgets\AdminMenu::EVENT_INIT,
			'callback' => ['humhub\modules\Note\Events', 'onAdminMenuInit']
		],
	],
];
?>

