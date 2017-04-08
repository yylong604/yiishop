<?php

namespace backend\controllers;

use backend\models\GoodsIntro;

class GoodsIntroController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model=new GoodsIntro();
        return $this->render('index',['model'=>$model]);
    }


    public function actionAdd()
    {
        $model=new GoodsIntro();
        return $this->render('index',['model'=>$model]);
    }


    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }

}
