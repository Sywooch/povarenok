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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/reset.css',
		'css/admin/font-awesome/css/font-awesome.css',		
        'css/site.css',
        'css/navbar.css',
        'css/catalog/block.css',
		'css/admin/plugins/toastr/toastr.min.css',
		'css/admin/plugins/iCheck/custom.css',
		'css/ingredients/list.css',
		'js/fancybox/jquery.fancybox.css',
		'css/popup-sidebar.css'
		
    ];
    public $js = [
		'js/site/plugins/autocolumnlist/jquery.autocolumnlist.js',
		'js/site/plugins/autocolumnlist/autocolumnlist.init.js',	
		'js/library/plugins/toastr/toastr.min.js',
		'js/library/plugins/iCheck/icheck.min.js',
		'js/site/main.js',
		'js/site/aver-comment.js',
		'js/site/aver-messages.js',
		'js/fancybox/jquery.fancybox.js',
		'js/fancybox/init.js',	
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',	
    ];
}
