<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Форма входа';
?>
<div class="item-preview">

	<?php $form = ActiveForm::begin([
		'id' => 'login-modal',
		]); ?>

		<div class="page_block_header">Форма входа</div>

		<?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

		<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

		<?= $form->field($model, 'rememberMe')->checkbox()->label("Запомнить меня") ?>

		<div class="">
			<?= Html::submitButton('Войти', ['class' => 'btn btn-sm btn-success', 'name' => 'login-button']) ?>
			<?= Html::a('Регистрация', ['site/register'], ['class' => 'btn btn-sm btn-default']) ?>
			<?= Html::a('Забыли пароль?', ['site/request-password-reset']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
