<?php 
$this->registerCssFile('/css/users/list.css',['depends' => ['app\assets\AppAsset']]);	

use yii\widgets\LinkPager;
?>

<div class="item_users">

	<div class="item-preview">

		<div class="page_block_header"><h1><?= Yii::$app->view->title; ?></h1></div>
		
		<div class="row">
			
			<?= $this->render('user_card',['models' => $models]); ?>
			
		</div>
		
	</div>
	
</div>	
<?php
// display pagination
echo LinkPager::widget([
    'pagination' => $pagination
]);
?> 