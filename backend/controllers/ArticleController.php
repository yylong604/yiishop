<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化并查找
        $query=Article::find();
        //实例化分页组件
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //查找分页数据
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        //分配到视图
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }

    //add
    public function actionAdd()
    {
        //实例化文章模型
        $model=new Article();
        //实例化文章内容模型
        $ad_model=new ArticleDetail();
        //实例化post组件
        $request=new Request();
        //判断为post提交
        if($request->isPost){
            //加载文章数据
            $model->load($request->post());
            //加载文章内容数据
            $ad_model->load($request->post());
            //判断两个模型同时通过验证
            if($model->validate() && $ad_model->validate()){
                //添加时间
                $model->inputtime=time();
                //保存文章内容
                $model->save();
                //获得文章id赋值给$ad_model里的article_id
                $ad_model->article_id=$model->id;
                //保存
                $ad_model->save();
                //提示跳转
                \Yii::$app->session->setFlash('success','保存成功!');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }

        return $this->render('add',['model'=>$model,'ad_model'=>$ad_model]);
    }


    //edit
    public function actionEdit($id)
    {
        //实例化文章模型
        $model=Article::findOne($id);
        //实例化文章内容模型
        $ad_model=ArticleDetail::findOne($id);
        //实例化post组件
        $request=new Request();
        //判断为post提交
        if($request->isPost){
            //加载文章数据
            $model->load($request->post());
            //加载文章内容数据
            $ad_model->load($request->post());
            //判断两个模型同时通过验证
            if($model->validate() && $ad_model->validate()){
                //更新时间
                $model->inputtime=time();
                //保存文章内容
                $model->save();
                //获得文章id赋值给$ad_model里的article_id
                $ad_model->article_id=$model->id;
                //保存
                $ad_model->save();
                //提示跳转
                \Yii::$app->session->setFlash('success','修改成功!');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'ad_model'=>$ad_model]);
    }

    //del
    public function actionDel($id)
    {
        //找到文章
        $model=Article::findOne($id);
        //找到内容
        $ad_modle=ArticleDetail::findOne($id);
        //删除内容
        $ad_modle->delete();
        //删除文章
        $model->delete();
        //提示跳转
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['article/index']);
    }

}
