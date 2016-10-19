<?php

use yii\helpers\Html;

?>
<div class="form-group">
	<?= Html::input('hidden','datax','',['id'=>'dataX']); ?>
	<?= Html::input('hidden','datay','',['id'=>'dataY']); ?>
	<?= Html::input('hidden','width','',['id'=>'dataWidth']); ?>
	<?= Html::input('hidden','height','',['id'=>'dataHeight']);	?>					
	<div class="block-hide">	
		<div class="row">
			<div class="col-md-9">					
				<div class="img-container">
					<img src="" id="img-cropper" alt="">
				</div>
			</div>
			<div class="col-md-3">
				<div class="docs-preview clearfix">				
					<div class="img-preview preview-md"></div>	
					<div class="img-preview preview-sm"></div>	
				</div>
			</div>
		</div>
	</div>	
</div>	