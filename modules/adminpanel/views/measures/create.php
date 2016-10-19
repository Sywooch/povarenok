<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\recepty\models\Measures */

$this->title = 'Создать меру веса';
$this->params['breadcrumbs'][] = ['label' => 'Мера веса', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measures-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
