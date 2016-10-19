<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use yii\web\View;

class ImageEditorWidget extends \yii\bootstrap\Widget
{
    public $width;
    public $height;	
    public $image_id;	
	

    public function init()
    {
        parent::init();
        $this->registerClientScript();
    }	
	
    public function run()
    {
		return $this->render('image_editor', [
			'widget' => $this,
		]);
    }
	
	public function registerClientScript()
    {
		$view = $this->getView();

		$view->registerCssFile('/css/admin/plugins/cropper/cropper.css',['depends' => ['app\assets\ImageAsset']]);
		$view->registerCssFile('/css/admin/plugins/cropper/main.css',['depends' => ['app\assets\ImageAsset']]);

		$view->registerJsFile('/js/library/plugins/cropper/cropper.js',['depends' => ['app\assets\ImageAsset']]);
		$view->registerJsFile('/js/library/plugins/cropper/tooltip.min.js',['depends' => ['app\assets\ImageAsset']]);
			
		$script = <<< JS
			var image = $("#img-cropper");
			var dataX = $("#dataX");
			var dataY = $("#dataY");
			var dataHeight = $("#dataHeight");
			var dataWidth = $("#dataWidth");
			var options = {
				  aspectRatio: $this->width / $this->height,
				  zoomable: true,
				  viewMode: 1,
				  minCropBoxWidth: $this->width,
				  minCropBoxHeight: $this->height,
				  preview: ".img-preview",
				  crop: function (e) {
					dataX.val(Math.round(e.x));
					dataY.val(Math.round(e.y));
					dataHeight.val(Math.round(e.height));
					dataWidth.val(Math.round(e.width));
				  }
				};
				
			image.cropper(options);
			
			// Import image
			var inputImage = $("$this->image_id");
			var URL = window.URL || window.webkitURL;
			var blobURL;

			if (URL) {
				inputImage.change(function () {

					var files = this.files;
					var file;

					if (!image.data("cropper")) {
						return;
					}

					if (files && files.length) {
						file = files[0];

						if (/^image\/\w+$/.test(file.type)) {
							blobURL = URL.createObjectURL(file);
							image.one("built.cropper", function () {
								URL.revokeObjectURL(blobURL); 
							}).cropper("reset").cropper("replace", blobURL);
							$(".block-hide").show();
						} else {
							body.tooltip("Please choose an image file.", "warning");
						}
					}
				});
			} else {
				inputImage.parent().remove();
			}
JS;
		$view->registerJs($script, View::POS_END);
	
	}	
	
}
