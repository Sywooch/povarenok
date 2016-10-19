<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\User;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\adminpanel\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-title">
				<h5><?= Html::encode($this->title) ?></h5>
				<div class="ibox-tools">
					<div class="btn-group">
						<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Действие <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a href="" class="no-href">Активировать</a></li>
							<li><a href="" class="no-href">Деактивировать</a></li>					
							<li class="divider"></li>
							<li><a href="" class="no-href" id="delete-items">Удалить</a></li>
						</ul>
					</div>				
					<?= Html::a('Создать', ['create'], ['class' => 'btn btn-primary btn-xs']) ?>
				</div>
			</div>
			<div class="ibox-content">
							
				<?= GridView::widget([	
					'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,
					'columns' => [
						['class' => 'yii\grid\CheckboxColumn'],
							
							[
								'label' => 'Изображение',
								'options' => ['style' => 'width:60px;'],								
								'format' => 'raw',
								'value' => function($data){
									return Html::img($data->imagePath,[
										'style' => 'height:40px;'
									]);
								},
							],
							'email:email',
							[
								'label' => 'Роль',
								'format' => 'raw',
								'value' => function($data){
									if (!empty($data->roleName)) return implode($data->roleName,', ');
								},
							],
							[
								'attribute' => 'updated_at',
								'label' => 'Дата посещения',
								'filter' => DatePicker::widget(
									[
										'model' => $searchModel,
										'attribute' => 'updated_at',
										'options' => [
											'class' => 'form-control'
										],
									]
								),
								'value' => function ($data) {
									return Yii::$app->formatter->asDate($data->updated_at);
								}
							],						
							[
								'attribute' => 'status',
								'label' => 'Admin',
								'filter' => Html::activeDropDownList($searchModel, 'status', ['' => 'Все', '0' => 'Удален', '10' => 'Активен'],['class' => 'form-control']),					
								'value' => function($data) {
									return ($data->status == 10) ? 'Активен' : 'Удален';
								}
							],
							
						[
							'class' => 'yii\grid\ActionColumn',
							'options' => ['style' => 'width:100px;'],
							'buttons' => [
								'view' => function($url, $model) {
									return Html::a('<i class="fa fa-eye"></i>', $model->getUrl(), ['class' => 'btn btn-primary btn-xs tt']);
								},
								'update' => function($url, $model) {
									return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['update', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
								},
								'delete' => function($url, $model) {
									return Html::a('<i class="fa fa-times"></i>', Url::toRoute(['delete', 'id' => $model->id]), ['class' => 'btn btn-danger btn-xs tt','data' => ['confirm' => 'Вы уверены, что хотите удалить эту запись?','method' => 'post']]);
								}
                            ],							
						],
					],
				]); ?>
				
			</div>
		</div>
	</div>
</div>