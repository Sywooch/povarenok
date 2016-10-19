<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Navigation */

$this->title = 'Изменить навигацию: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Навигация', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="navigation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
