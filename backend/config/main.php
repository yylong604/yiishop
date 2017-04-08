<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'class'=>\yii\web\User::className(),
            'identityClass' => \backend\models\Admin::className(),
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/login'],
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'qiniu'=>[
            'class'=>\backend\components\Qiniu::className(),
            'accessKey'=>'vg_CMChOKEbBjFaJU2_kBs5B4mjrOVnMx1IqCdqb',
            'secretKey'=>'ggCAHtgMKH2XPZ9vOb2JuvCjlQFHflYXWvdqJIbW',
            'domain'=>'http://onko5sc8g.bkt.clouddn.com/',
            'bucket'=>'yii-shop',
            'region'=>\backend\components\Qiniu::HOST_HUADONG,
        ],

    ],
    'params' => $params,
];
