<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Measures */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Мера веса', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measures-view">
    
	<p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этоу запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'active',
        ],
    ]) ?>

</div>
