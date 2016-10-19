<?php

use yii\helpers\Html;	
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use raoul2000\jcrop\JCropWidget;
use app\modules\adminpanel\models\AuthAssignment;


/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
	<div class="col-lg-12">
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
							'wrapper' => 'col-sm-10'
						],
					],
				]); ?>

				<div class="row">
					<div class="col-md-10">

						<?= $form->field($model, 'username')->textInput() ?>
						
						<?= $form->field($model, 'email')->textInput() ?>

						<?= $form->field($model, 'status')->dropDownList($model->statusesArray) ?>
						
						<?= $form->field($model, 'roleName')->dropDownList(ArrayHelper::map(AuthAssignment::getItems(), 'name', 'description'),['class' => 'form-control chosen-select','multiple' => 'true']) ?>
						
						<div class="hr-line-dashed"></div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<?= Html::a('Назад',['index'],['class' => 'btn btn-white']); ?>
								<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
							</div>
						</div>
													
					</div>
					<div class="col-md-2">
						<?= Html::img($model->imagePath, ['class' => 'img-responsive']); ?>
					</div>
				</div>

				<?php ActiveForm::end(); ?>

			</div>	
		</div>
	</div>	
</div>
