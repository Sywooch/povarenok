<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'active:boolean',
            'name',
            'path',
            'prioritet',
            'short_description:ntext',
            'keywords',
            'description',
			[
				'label' => 'Изображение',
				'format' => 'raw',
				'value' => Html::img($model->imagePath, ['height' => '90px']),
			],
            'title',
            'recept:ntext',
            'count_show',			
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
