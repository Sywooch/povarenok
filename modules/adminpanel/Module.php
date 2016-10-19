<?php

namespace app\modules\adminpanel;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class Module extends \yii\base\Module
{
	public $layout = 'main';	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\adminpanel\controllers';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'site';
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
