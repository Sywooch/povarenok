<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Measures */

$this->title = 'Изменить меру веса: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Мера веса', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="measures-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
