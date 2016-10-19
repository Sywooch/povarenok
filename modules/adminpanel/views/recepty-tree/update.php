<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\ReceptyTree */

$this->title = 'Изменить категорию: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории рецептов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="recepty-tree-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
