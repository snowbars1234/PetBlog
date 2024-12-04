<?php

namespace app\modules\user;
use Yii;
use yii\filters\AccessControl;
/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [

            'access' => [

                'class' => AccessControl::className(),

                'denyCallback' => function ($rule, $action) {

                    throw new \yii\web\NotFoundHttpException();

                },

                'rules' => [

                    [

                        'allow' => true,

                        'matchCallback' => function ($rule, $action) {

                            return !Yii::$app->user->isGuest;}
                    ]

                ]

            ]

        ];
    }
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
