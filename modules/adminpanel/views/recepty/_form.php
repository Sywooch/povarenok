<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\modules\recepty\models\ReceptyTree;
use app\modules\recepty\models\Ingredients;
use app\modules\recepty\models\Measures;
use app\widgets\ImageEditorWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Recepty */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="recepty-form">
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
					'label' => 'col-sm-3',
					'wrapper' => 'col-sm-9',
					'offset' => 'col-sm-offset-3'
				],
				'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox-inline i-checks\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{endWrapper}\n{hint}"
			]
		]); ?>
		
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#tab-1">Общее</a></li>
			<li class=""><a data-toggle="tab" href="#tab-2">Описание</a></li>
			<li class=""><a data-toggle="tab" href="#tab-3">Meta</a></li>
			<li class=""><a data-toggle="tab" href="#tab-4">Видео</a></li>
		</ul>
		<div class="tab-content panel-body">
			
			<div id="tab-1" class="tab-pane active">

				<?= $form->field($model, 'active')->checkbox() ?>

				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'path')->textInput(['maxlength' => true, 'class' => 'form-control translit']) ?>
				
				<?= $form->field($model, 'treeArray')->dropDownList(ArrayHelper::map(ReceptyTree::find()->all(), 'id', 'name'),['class' => 'form-control chosen-select','multiple' => 'true']); ?>
					
				<?= $form->field($model, 'time')->textInput() ?>

				<?= $form->field($model, 'prioritet')->textInput() ?>

				<?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>

				<?= $form->field($model, 'image')->fileInput(['id' => 'inputImage']) ?>
				
				<?= ImageEditorWidget::widget([
					'image_id' => '#inputImage',
					'width' => Yii::$app->params['recepty_image']['image']['small']['width'],
					'height' => Yii::$app->params['recepty_image']['image']['small']['height'],					
				]); ?>	
						
				<div class="form-group">	
					<div class="col-md-offset-3 col-md-9">
						<?= Html::img($model->imagePath,['class' => 'img-responsive']); ?>
					</div>
				</div>

				<div id="clone-ingredient">
										
					<?php foreach($model->ingredients as $elem): ?>
				
					<div class="clone">
						<div class="row">
							<div class="col-xs-4">
								<?= $form->field($elem, '['.$elem['id'].']ingredient_id')->dropDownList(ArrayHelper::map(Ingredients::find()->all(), 'id', 'name'),['class' => 'chosen-select','data-placeholder'=>'Выберите ингридиент...']); ?>				
							</div>
							<div class="col-xs-3">
								<?= $form->field($elem, '['.$elem['id'].']kolvo')->textInput(); ?>
							</div>
							<div class="col-xs-4">
								<?= $form->field($elem, '['.$elem['id'].']id_measure')->dropDownList(ArrayHelper::map(Measures::find()->all(), 'id', 'name'),['class' => 'chosen-select','data-placeholder'=>'Выберите меру...']); ?>	
							</div>
							<div class="col-xs-1">
								<a href="#" onclick="return removeIngrow(this)"class="btn btn-xs btn-danger ingredient-delete del-clone"><i class="fa fa-trash"></i></a>
							</div>
						</div>
					</div>
					
					<?php endforeach; ?>										
					
				</div>	
				

					<div class="text-center">
						<a class="btn btn-success add-clone" rel="clone-ingredient">Добавить еще</a>							
					</div>
		
			</div>	
			
			<div id="tab-2" class="tab-pane">
				<?= $form->field($model, 'recept')->textarea(['rows' => 6]) ?>			
			</div>
			
			<div id="tab-3" class="tab-pane">	
				<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
			</div>
			
			<div id="tab-4" class="tab-pane">	
				<?= $form->field($model, 'url_video')->textInput(['maxlength' => true]) ?>
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
</div>
