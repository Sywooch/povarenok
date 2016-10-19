<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Ingredients */

$this->title = 'Создать ингредиент';
$this->params['breadcrumbs'][] = ['label' => 'Ингредиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredients-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
