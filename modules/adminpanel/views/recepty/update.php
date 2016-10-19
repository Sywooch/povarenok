<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Recepty */

$this->title = 'Изменить рецепт: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рецепты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="recepty-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
