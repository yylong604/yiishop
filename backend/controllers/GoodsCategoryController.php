<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\db\Exception;
use yii\helpers\Json;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=GoodsCategory::find()->orderBy('tree,lft')->all();

        return $this->render('index',['models'=>$models]);
    }

    public function actionAdd()
    {
        //实例化模型
        $model=new GoodsCategory();
        //加载数据并验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //判断 0 时创建一级分类
            if($model->parent_id==0){
                //创建一级分类
                $model->makeRoot();
            //部位 1 时
            }else{
                //根据id获得需要追加的模型
                $cate_model=GoodsCategory::findOne(['id'=>$model->parent_id]);
                //追加下一级分类
                $model->prependTo($cate_model);
            }
            //提示
            \Yii::$app->session->setFlash('success','添加分类成功!');
            //刷新
            return $this->refresh();

        }
        //获取数据
        $models=GoodsCategory::find()->asArray()->all();
        //顶级分类
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        //转为json数据
        $models=Json::encode($models);
        //分配到页面
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }


    public function actionEdit($id)
    {
        //实例化模型
        $model=GoodsCategory::findOne(['id'=>$id]);
        //加载数据并验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            try{
                //判断 0 时创建一级分类
                if($model->parent_id==0){
                    //创建一级分类
                    $model->makeRoot();

                    //部位 1 时
                }else{
                    //根据id获得需要追加的模型
                    $cate_model=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    //追加下一级分类
                    $model->prependTo($cate_model);
                    //提示
                    \Yii::$app->session->setFlash('success','修改分类成功!');
                    //刷新
                    return $this->refresh();
                }
            }catch(Exception $e){
                $model->addError('parent_id',$e->getMessage());
            }
        }
        //获取数据
        $models=GoodsCategory::find()->asArray()->all();
        //顶级分类
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        //转为json数据
        $models=Json::encode($models);
        //分配到页面
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }


/*
   public function actionTest()
    {
        $model=GoodsCategory::find()->all();
        return $this->renderPartial('test',['model'=>$model]);
    }*/

    public function actionDel($id)
    {
        $model=GoodsCategory::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['goods-category/index']);

    }
}
