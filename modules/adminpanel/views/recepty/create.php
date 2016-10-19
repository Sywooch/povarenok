<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Recepty */

$this->title = 'Создать рецепт';
$this->params['breadcrumbs'][] = ['label' => 'Рецепты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recepty-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
