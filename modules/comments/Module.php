<?php

namespace app\modules\comments;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class Module extends \yii\base\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\comments\controllers';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'site';
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

}
