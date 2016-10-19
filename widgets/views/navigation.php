<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

	NavBar::begin([
		'options' => [
			'class' => 'navbar navbar-default',
		],
	]);
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav'],
		'items' => $items,
	]);
	NavBar::end();
