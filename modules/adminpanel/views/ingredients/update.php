<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Ingredients */

$this->title = 'Редактировать ингредиент: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ингредиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="ingredients-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
