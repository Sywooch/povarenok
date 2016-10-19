<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\ReceptyTree */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории рецептов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recepty-tree-view">

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
            'pid',
            'level',
            'name',
            'path',
			[
				'label' => 'Изображение',
				'format' => 'raw',
				'value' => Html::img($model->imagePath, ['height' => '90px']),
			],
            'active',
            'prioritet',
            'title',
            'keywords',
            'description',
            'short_description:ntext',
        ],
    ]) ?>

</div>
