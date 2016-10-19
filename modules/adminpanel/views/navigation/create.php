<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Navigation */

$this->title = 'Создать навигацию';
$this->params['breadcrumbs'][] = ['label' => 'Навигация', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="navigation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
