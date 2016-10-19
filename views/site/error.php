<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="item-preview">

    <div class="page_block_header"><h1><?= Html::encode($this->title) ?></h1></div>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
		Извините, но страница, которую вы ищете, не была найдена. Попробуйте проверить URL на ошибку, 
		а затем нажмите кнопку обновления в браузере либо попробуйте найти что-то еще в нашем приложении.
    </p>
	<a href="/" title="На главную">На главную</a>

</div>
