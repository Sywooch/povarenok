<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\modules\article\models\ArticleTree;
use app\widgets\ImageEditorWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ibox">
	<div class="ibox-title">
		<h5>Редактирование</h5>				
	</div>
	<div class="ibox-content">
		
    <?php $form = ActiveForm::begin([
			'layout' => 'horizontal',
			'options' => [
				'enctype' => 'multipart/form-data'
			],
			'fieldConfig' => [
				'horizontalCssClasses' => [
					'label' => 'col-sm-2',
					'wrapper' => 'col-sm-10',
					'offset' => 'col-sm-offset-2'
				],
				'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox-inline i-checks\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{endWrapper}\n{hint}"
			]
		]); ?>
		
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#tab-1">Общее</a></li>
			<li class=""><a data-toggle="tab" href="#tab-2">Описание</a></li>
			<li class=""><a data-toggle="tab" href="#tab-3">Meta</a></li>
		</ul>
		<div class="tab-content panel-body">
			
			<div id="tab-1" class="tab-pane active">

				<?= $form->field($model, 'active')->checkbox() ?>

				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'path')->textInput(['maxlength' => true, 'class' => 'form-control translit']) ?>

				<?= $form->field($model, 'treeArray')->dropDownList(ArrayHelper::map(ArticleTree::find()->all(), 'id', 'name'),['class' => 'form-control chosen-select','multiple' => 'true']) ?>
			
				<?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>

				<?= $form->field($model, 'prioritet')->textInput() ?>

				<?= $form->field($model, 'image')->fileInput(['id' => 'inputImage']) ?>
				
				<?= ImageEditorWidget::widget([
					'image_id' => '#inputImage',
					'width' => Yii::$app->params['article']['image']['small']['width'],
					'height' => Yii::$app->params['article']['image']['small']['height'],					
				]); ?>	
				
				<div class="form-group">	
					<div class="col-md-offset-2 col-md-10">
						<?= Html::img(Yii::$app->params['article']['image']['small']['path'].$model->image,['class' => 'img-responsive']); ?>
					</div>
				</div>
				
			</div>
			<div id="tab-2" class="tab-pane">

				<?= $form->field($model, 'recept')->textarea(['rows' => 6]) ?>
	
			</div>
			<div id="tab-3" class="tab-pane">
						
				<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'keywords')->textarea(['maxlength' => true]) ?>

				<?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
			</div>
															
			<div class="hr-line-dashed"></div>
		
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<?= Html::a('Назад',['index'],['class' => 'btn btn-white']); ?>							
					<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>
			</div>
			
		</div>	
    <?php ActiveForm::end(); ?>
	
	</div>

</div>
