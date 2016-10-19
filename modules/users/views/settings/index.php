<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $profile app\modules\users\models\UsersProfile */
/* @var $form ActiveForm */
?>

<div class="item-preview">

	<div class="page_block_header">Основное</div>
		

	<?php $form = ActiveForm::begin([			
			'layout' => 'horizontal',
			'fieldConfig' => [
				'horizontalCssClasses' => [
					'label' => 'col-sm-2',
					'wrapper' => 'col-sm-10',
					'offset' => 'col-sm-offset-2'
				],
			]
	]); ?>

		<?= $form->field($user, 'username')->textInput() ?>
		
		<?= $form->field($user, 'email')->textInput() ?>
		
		<?= $form->field($profile, 'name')->textInput() ?>
		
		<?= $form->field($profile, 'sex')->dropDownList($profile->sexDropList) ?>
		
		<?= $form->field($profile, 'city')->textInput() ?>
		
		<?= $form->field($profile, 'current_info')->textInput() ?>
		
		<?= $form->field($profile, 'about')->textarea(['rows' => 6]) ?>
		
		<?= $form->field($profile, 'interes')->textarea(['rows' => 6]) ?>
	
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
</div>
