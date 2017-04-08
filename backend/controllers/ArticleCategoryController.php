<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Request;

class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化并查找
        $query=ArticleCategory::find()->where(['!=','status','-1']);
        //实例化分页组件
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //查找指定分页数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //分配到页面
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }

    //add
    public function actionAdd()
    {
        //实例化
        $model = new ArticleCategory();
        //实例化post接收组件
        $request=new Request();
        //判断提交范式
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //判读验证规则
            if($model->validate()){
                //通过规则时 保存数据
                $model->save();
            }else{
                //不通过是打印退出
                var_dump($model->getErrors());exit;
            }
            //提示跳转
            \Yii::$app->session->setFlash('success','添加成功!');
            return $this->redirect(['article-category/index']);
        }
        //分配到页面

        return $this->render('add',['model'=>$model]);
    }


    //edit
    public function actionEdit($id)
    {
        //实例化
        $model = ArticleCategory::findOne($id);
        //实例化post接收组件
        $request=new Request();
        //判断提交范式
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //判读验证规则
            if($model->validate()){
                //通过规则时 保存数据
                $model->save();
            }else{
                //不通过是打印退出
                var_dump($model->getErrors());exit;
            }
            //提示跳转
            \Yii::$app->session->setFlash('success','修改成功!');
            return $this->redirect(['article-category/index']);
        }
        //分配到页面

        return $this->render('add',['model'=>$model]);
    }

    //del 删除时放到回收站
    public function actionDel($id)
    {
        $model=ArticleCategory::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['article-category/index']);

    }


    //recycle 回收站
    public function actionRecycle()
    {
        //根据status=-1查找所以数据
        $query=ArticleCategory::find()->where(['=','status','-1']);
        //实例化分页组件
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>2,
        ]);
        //获取数据
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        //分配页面
        return $this->render('recycle',['models'=>$models,'pager'=>$pager]);
    }

    //恢复
    public function actionReback($id)
    {
        $model=ArticleCategory::findOne($id);
        $model->status=1;
        $model->save();
        \Yii::$app->session->setFlash('success','恢复成功!');
        return $this->redirect(['article-category/index']);
    }

    //清除
    public function actionRedel($id)
    {
        $model=ArticleCategory::findOne($id);
        $model->delete();
        \Yii::$app->session->setFlash('success','清除成功!');
        return $this->redirect(['article-category/recycle']);
    }
}
