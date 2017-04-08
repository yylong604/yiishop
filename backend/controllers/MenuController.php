<?php

namespace backend\controllers;

use backend\models\Menu;

class MenuController extends \yii\web\Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionAdd()
    {
        $model=new Menu();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            $this->refresh();
        }
        return $this->render('add',['model'=>$model]);
    }


    public function actionEdit($id)
    {
        $model=Menu::findOne($id);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            $this->refresh();
        }
        return $this->render('add',['model'=>$model]);
    }

    //del
    public function actionDel($id)
    {
        $model=Menu::findOne($id);
        $model->delete();

    }
}
