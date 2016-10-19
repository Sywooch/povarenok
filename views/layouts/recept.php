<?php

use app\modules\recepty\widgets\CategoriesWidget;
use app\modules\recepty\widgets\PopularReceptWidget;
use app\modules\users\widgets\UserMenuWidget;

?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
	<div class="row">
		<div class="col-md-3 col-sm-4">
			
			<?php
				if (!Yii::$app->user->isGuest) {
					echo UserMenuWidget::widget(); 
				}
				
				echo CategoriesWidget::widget([
					'category' => isset($this->params['category']) ? $this->params['category'] : null,
				]);
					
				echo PopularReceptWidget::widget(); 
				
			?>
		
		</div>
		<div class="col-md-9 col-sm-8">	
			<?= $content; ?>
		</div>
	</div>
<?php $this->endContent(); ?>
