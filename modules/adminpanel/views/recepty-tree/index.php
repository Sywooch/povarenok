<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\modules\recepty\models\ReceptyTree;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\adminpanel\models\ReceptyTreeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории рецептов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recepty-tree-index">

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
		
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
			[
				'attribute' => 'pid',
				'format' => 'raw',
				'filter' => ReceptyTree::find()->select(['name','id'])->orderBy(['pid' => SORT_ASC])->indexBy('id')->column(),
				'value' => function($data) {
					return ReceptyTree::findOne($data->pid)['name'];
				}
			],
            'name',
            'path',
            // 'image',
            // 'active',
            // 'prioritet',
            // 'title',
            // 'keywords',
            // 'description',
            // 'short_description:ntext',

            [
				'class' => 'yii\grid\ActionColumn',
				'options' => ['style' => 'width:100px;'],
				'buttons' => [
					'view' => function($url, $model) {
						return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['view', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
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
