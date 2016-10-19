<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Recepty */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рецепты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recepty-view">

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
            'active',
            'name',
            'path',
            'prioritet',
            'short_description:ntext',
            'title',
            'keywords',
            'description',
			[
				'label' => 'Изображение',
				'format' => 'raw',
				'value' => Html::img($model->imagePath, ['height' => '90px']),
			],
            'time:integer',
            'url_video:url',
            'recept:ntext',
            'date_create:date',
            'count_show',
            'count_like',
            'count_note',
        ],
    ]) ?>

</div>
