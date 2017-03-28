<?php

namespace backend\controllers;

use app\models\Brand;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;


class BrandController extends \yii\web\Controller
{

    //index
    public function actionIndex()
    {
        //实例化并调用find方法
        $query=Brand::find()->where(['!=','status','-1']);
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



    //add
    public function actionAdd()
    {
        $model=new Brand();//1.实例化对象
        //实例化上传组件
        $request=new Request();
        //判断post提交方式
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //实例化图片属性
          //  $model->logo_file=UploadedFile::getInstance($model,'logo_file');
            //验证规则
            if($model->validate()){
                //判断图片是否存在
              /*  if($model->logo_file){
                    //生成文件路径
                    $file_name='upload/brand/'.uniqid().'.'.$model->logo_file->extension;
                    //保存到属性上  false不删除临时文件
                    $model->logo_file->saveAs($file_name,false);
                    //赋值给logo
                    $model->logo=$file_name;
                }*/
//                var_dump($model->logo);exit;
                //保存到数据库
                $model->save();
                //设置友好提示
                \Yii::$app->session->setFlash('success','添加成功!');
                //跳转到首页
                return $this->redirect(['brand/index']);
            }else{//没通过验证时 答应错误信息并退出
                var_dump($model->getErrors());exit;
            }
        }
        //展示添加页面
        return $this->render('add',['model'=>$model]);//2.显示视图
    }


    //edit
    public function actionEdit($id)
    {
        $model=Brand::findOne($id);//1.实例化对象
        //实例化上传组件
        $request=new Request();
        //判断post提交方式
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //实例化图片属性
           // $model->logo_file=UploadedFile::getInstance($model,'logo_file');
            //验证规则
            if($model->validate()){
                //判断图片是否存在
               /* if($model->logo_file){
                    //生成文件路径
                    $file_name='upload/brand/'.uniqid().'.'.$model->logo_file->extension;
                    //保存到属性上  false不删除临时文件
                    $model->logo_file->saveAs($file_name,false);
                    //赋值给logo
                    $model->logo=$file_name;
                }*/
//                var_dump($model->logo);exit;
                //保存到数据库
                $model->save();
                //设置友好提示
                \Yii::$app->session->setFlash('success','添加成功!');
                //跳转到首页
                return $this->redirect(['brand/index']);
            }else{//没通过验证时 答应错误信息并退出
                var_dump($model->getErrors());exit;
            }
        }
        //展示添加页面
        return $this->render('add',['model'=>$model]);//2.显示视图
    }

    //del
    public function actionDel($id)
    {
        //实例化并查找到数据
        $model = Brand::findOne(['id'=>$id]);
        //
        $model->status=-1;
        $model->save();
        //提示并跳转
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['brand/index']);
    }

    /*
     * 删除时 隐藏数据 到回收站
     */

    public function actionRecycle()
    {
        //实例化并根据条件查找数据
        $query = Brand::find()->where(['=','status','-1']);
        //实例化分页组件
        $pager=new Pagination([
            'totalCount'=>$query->all(),
            'pageSize'=>3,
        ]);
        //查找分页数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //分配到页面
        return $this->render('recycle',['models'=>$models,'pager'=>$pager]);
    }

    /*
     * 删除回收站
     */
    public function actionRedel($id)
    {
        $brand=Brand::findOne($id);
        $brand->delete();
        //提示并跳转
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['brand/recycle']);
    }
    /*
     * 恢复回收站
     */
    public function actionReback($id)
    {
        $brand=Brand::findOne($id);
        $brand->status=1;
        $brand->save();
        //提示并跳转
        \Yii::$app->session->setFlash('success','恢复成功!');
        return $this->redirect(['brand/index']);
    }

    /*
     *
     */

    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/brand',
                'baseUrl' => '@web/upload/brand',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /*'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }
}
