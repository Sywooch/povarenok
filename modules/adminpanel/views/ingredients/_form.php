<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Ingredients */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="ingredients-form">
<div class="ibox">
	<div class="ibox-title">
		<h5>Редактирование</h5>				
	</div>
	<div class="ibox-content">
		
    <?php $form = ActiveForm::begin([
			'layout' => 'horizontal',
			'fieldConfig' => [
				'horizontalCssClasses' => [
					'label' => 'col-sm-2',
					'wrapper' => 'col-sm-10',
					'offset' => 'col-sm-offset-2'
				],
				'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox-inline i-checks\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{endWrapper}\n{hint}"
			]
		]); ?>

		<?= $form->field($model, 'active')->checkbox() ?>

		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'path')->textInput(['maxlength' => true, 'class' => 'form-control translit']) ?>

		<?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'belki')->textInput() ?>

		<?= $form->field($model, 'zhiri')->textInput() ?>

		<?= $form->field($model, 'yglevodi')->textInput() ?>

		<?= $form->field($model, 'kkal')->textInput() ?>
														
		<div class="hr-line-dashed"></div>
	
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<?= Html::a('Назад',['index'],['class' => 'btn btn-white']); ?>							
				<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
		
    <?php ActiveForm::end(); ?>
		
	</div>

</div>
</div>
