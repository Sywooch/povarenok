<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [	
		'css/admin/font-awesome/css/font-awesome.css',
		'css/admin/plugins/iCheck/custom.css',
		'css/admin/plugins/chosen/chosen.css',
		'css/admin/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css',
		'css/admin/plugins/toastr/toastr.min.css',
		'css/admin/animate.css',
		'css/admin/style.css'		
    ];
    public $js = [	
		'js/admin/functions.js',
		'js/library/plugins/metisMenu/jquery.metisMenu.js',
		'js/library/plugins/slimscroll/jquery.slimscroll.min.js',
		'js/library/inspinia.js',
		'js/library/plugins/pace/pace.min.js',
		'js/library/plugins/jquery-ui/jquery-ui.min.js',
		'js/library/plugins/iCheck/icheck.min.js',
		'js/library/plugins/toastr/toastr.min.js',
		'js/library/plugins/chosen/chosen.jquery.js',
		'js/library/plugins/chosen/init.js',
		'js/admin/admin.js'	
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
