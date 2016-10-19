<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\comments\models\UsersComment */

$this->title = 'Изменить комментарий: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="users-comment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
