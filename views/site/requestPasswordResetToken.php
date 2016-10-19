<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Запрос на сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="item-preview">

	<div class="page_block_header"><?= Html::encode($this->title) ?></div>

	<p>Пожалуйста, введите вашу электронную почту. Ссылка для сброса пароля будет отправлена туда.</p>

	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

				<?= $form->field($model, 'email') ?>

				<div class="form-group">
					<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
				</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
