<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\comments\models\UsersComment */

$this->title = 'Создать комментарий';
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-comment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
