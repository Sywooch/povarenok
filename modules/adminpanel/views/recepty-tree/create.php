<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\ReceptyTree */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории рецептов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recepty-tree-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
