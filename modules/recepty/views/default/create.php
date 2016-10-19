<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\modules\recepty\models\ReceptyTree;
use app\modules\recepty\models\Ingredients;
use app\modules\recepty\models\Measures;
use app\widgets\ImageEditorWidget;


$this->registerCssFile('/css/admin/plugins/chosen/chosen.css',['depends' => ['app\assets\AppAsset']]);	
$this->registerCssFile('/css/users/list.css',['depends' => ['app\assets\AppAsset']]);
$this->registerCssFile('/css/catalog/add.css',['depends' => ['app\assets\AppAsset']]);

$this->registerJsFile('/js/library/plugins/chosen/chosen.jquery.js',['depends' => ['app\assets\AppAsset']]);	
$this->registerJsFile('/js/library/plugins/chosen/init.js',['depends' => ['app\assets\AppAsset']]);	
$this->registerJsFile('/js/admin/admin.js',['depends' => ['app\assets\AppAsset']]);	
$this->registerJsFile('/js/admin/functions.js',['depends' => ['app\assets\AppAsset']]);	
/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Recepty */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="item-preview">

	<div class="page_block_header">
		<h1><?= Yii::$app->view->title; ?></h1>
	</div>
		
	<?php if (\Yii::$app->user->can('admin')): ?>	
    <?php $parse_form = ActiveForm::begin(); ?>
		
		<div class="form-group">
			<label for="Ссылка"></label>
			<?= $parse_form->field($parse_model,'url')->label(false); ?>
			<small>
				Перейти на <a href="http://www.povarenok.ru/recipes/" target="_ablank" title="">сайт</a> где брать ссылки.<br/>
				Примечание: не по всем ссылкам могут быть добавлены данные, если данные не добавляются попробуйте другую ссылку.
			</small>
			<div class="">
				<?= Html::submitButton('Добавить данные',['class' => 'btn btn-sm btn-primary']); ?>
			</div> 								
		</div>			
	<?php ActiveForm::end(); ?>
	<?php endif; ?>	
		
    <?php $form = ActiveForm::begin([
			'options' => [
				'enctype' => 'multipart/form-data'
			],
		]); ?>
		
		<ul class="page_block_tabs">
			<li class="friend-tab active"><a data-toggle="tab" href="#tab-1">Общее</a></li>
			<li class="friend-tab"><a data-toggle="tab" href="#tab-2">Meta</a></li>
			<li class="friend-tab"><a data-toggle="tab" href="#tab-3">Видео</a></li>
		</ul>
		<div class="tab-content panel-body">
			
			<div id="tab-1" class="tab-pane active">

				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'time')->textInput() ?>

				<div class="form-group">
				<?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>
				<small>Обязательно напишите 2-3 строки - что это за блюдо, его особенности, вкусовые качества. Этот текст будет показываться в качестве анонса к Вашему рецепту - и именно по этому тексту люди будут определять, стоит читать Ваш рецепт - или нет.</small>
				</div>
				
				<?= $form->field($model, 'image')->fileInput(['id' => 'inputImage']) ?>
				
				<?= ImageEditorWidget::widget([
					'image_id' => '#inputImage',
					'width' => Yii::$app->params['recepty_image']['image']['small']['width'],
					'height' => Yii::$app->params['recepty_image']['image']['small']['height'],					
				]); ?>	
				
				<div class="form-group">
				<?= $form->field($model, 'treeArray')->dropDownList(ArrayHelper::map(ReceptyTree::find()->all(), 'id', 'name'),['class' => 'form-control chosen-select','multiple' => 'true']); ?>
				<small>Можно выбирать несколько разделов.</small>
				</div>
				
				<div class="form-group">
					<?= $form->field($model, 'recept')->textarea(['rows' => 6]) ?>	
					<small class="small">
						Здесь пишите способ приготовления блюда. Рекомендуется шаги разделять энтерами и чередовать цифрами.<br/>
						Например:<br/>
						1. Духовку разогреть до 210 С. Ванильный сахар смешать с обычным сахаром. <br/>
						2. Всыпать просеянную муку и какао, перемешать.
					</small>
				</div>
				
				<div id="clone-ingredient">
										
					<?php foreach($model->ingredients as $elem): ?>
				
					<div class="clone">
						<div class="row">
							<div class="col-sm-4">
								<?= $form->field($elem, '['.$elem['id'].']ingredient_id')->dropDownList(ArrayHelper::map(Ingredients::find()->all(), 'id', 'name'),['class' => 'chosen-select','data-placeholder'=>'Выберите ингридиент...']); ?>				
							</div>
							<div class="col-sm-3">
								<?= $form->field($elem, '['.$elem['id'].']kolvo')->textInput(); ?>
							</div>
							<div class="col-sm-4 col-xs-9">
								<?= $form->field($elem, '['.$elem['id'].']id_measure')->dropDownList(ArrayHelper::map(Measures::find()->all(), 'id', 'name'),['class' => 'chosen-select','data-placeholder'=>'Выберите меру...']); ?>	
							</div>
							<div class="col-sm-1 col-xs-3">
								<a href="#" onclick="return removeIngrow(this)"class="btn btn-xs btn-danger ingredient-delete del-clone"><i class="glyphicon glyphicon-trash"></i></a>
							</div>
						</div>
					</div>
					
					<?php endforeach; ?>										
					
				</div>	

				<div class="text-center">
					<a class="btn btn-success btn-xs add-clone" rel="clone-ingredient">Добавить еще</a>							
				</div>
	
			</div>	
			
			<div id="tab-2" class="tab-pane">
				<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
			</div>
			
			<div id="tab-3" class="tab-pane">	
				<div class="form-group">
					<?= $form->field($model, 'url_video')->textInput(['maxlength' => true]) ?>
					<small>Урл на видео рецепт вставлять только из <a href="https://www.youtube.com/" tutle="youtube">youtube</a>.</small>
				</div>
			</div>
												
			<div class="hr-line-dashed"></div>
		
			<div class="form-group">
				<div class="">						
					<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>
			</div>
		
		</div>

    <?php ActiveForm::end(); ?>

</div>
