<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\Goods;
use frontend\models\LoginForm;
use Symfony\Component\Console\Helper\Helper;
use yii\data\Pagination;
use yii\web\Request;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化并调用find方法
        $query=Admin::find();
        //实例化分页组件
        $pager=new Pagination([
            //传入总条数
            'totalCount'=>$query->count(),
            //传入没有显示条数
            'pageSize'=>3,
        ]);
        //sql拼装
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //展示页面
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }

    public function actionAdd()
    {
        $model=new Admin();
        $request= new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //加密密码
                $model->password=\Yii::$app->getSecurity()->generatePasswordHash($model->password);

                //模拟数据
                $model->token=$model->getRandChar(32);
                $model->token_create_time=time();
                $model->add_time=time();

                $time=Admin::findOne('last_login_time');
                if($time){
                    $model->last_login_time='';
                }else{
                    $model->last_login_time='';
                    $model->last_login_ip='';
                }
                $model->save();

                //
                $authManager =  \Yii::$app->authManager;
                $role = $authManager->getRole($model->roles);
                //用户关联角色
                $authManager->assign($role,$model->id);

                \Yii::$app->session->setFlash('success','添加成功!');
                return $this->redirect(['admin/index']);

            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //edit
    public function actionEdit($id)
    {
        $model=Admin::findOne(['id'=>$id]);

        //回显权限
        $authManager = \Yii::$app->authManager;
      //  var_dump(array_keys($authManager->getRolesByUser($id)));exit;
        $model->roles=array_keys($authManager->getRolesByUser($id));

        $request= new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //加密密码
                $model->password=\Yii::$app->getSecurity()->generatePasswordHash($model->password);

                //模拟数据
                $model->token=$model->getRandChar(32);
                $model->token_create_time=time();
                $model->add_time=time();

                $time=Admin::findOne('last_login_time');
                if($time){
                    $model->last_login_time=$time;
                }else{
                    $model->last_login_time='';
                    $model->last_login_ip='';
                }
                $model->save();

                //
                $role = $authManager->getRole($model->roles);
                //用户关联角色
                $authManager->revokeAll($id);
                $authManager->assign($role,$model->id);

                \Yii::$app->session->setFlash('success','修改成功!');
                return $this->redirect(['admin/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }


    //delete
    public function actionDel($id)
    {
        $authManager =  \Yii::$app->authManager;
        $authManager->revokeAll($id);

        $model=Admin::findOne($id);
        $model->delete();

        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['admin/index']);
    }

    public function actionLogin()
    {
        //1.实例化模型
        $model=new \backend\models\LoginForm();
        $request=new Request();
        //2.判断提交方式
        if($request->isPost){
            //2.1加载数据
            $model->load($request->post());
            //2.2提交验证
            if($model->login()){
                //2.3成功跳转
                \Yii::$app->session->setFlash('success','登陆成功!');
                return $this->redirect(['admin/index']);
            }
        }
        //1.1展示页面
        return $this->render('login',['model'=>$model]);
    }


    public function actionTest()
    {
        $s = \Yii::$app->user->identity;
        var_dump($s);
    }
}
