<?php

namespace backend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\SearchForm;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\Request;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化搜索表单模型
        $model=new SearchForm();
        //找到状态为1的
        $query=Goods::find()->where(['status'=>1]);
        //实例化提交方式
        $request=new Request();
        //如果为get
        if($request->isGet){
            //接收并验证
            if($model->load($request->get()) && $model->validate()){
                //调用serch方法
               $model->search($query);
            }
        }
        //实例化分页组件
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //查找数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //分配数据
        return $this->render('index',['models'=>$models,'pager'=>$pager,'model'=>$model]);
    }


    //add
    public function actionAdd()
    {
        //实例化goods
        $model=new Goods();
        $content=new GoodsIntro();

        //接收值
        $request=new Request();
        if($request->isPost){
            if($model->load($request->post()) && $model->validate() && $content->load($request->post()) && $content->validate()){
                //保存
                $model->inputtime=time();//添加时间

                //定义一个时间
                $time=date('Ymd',time());
                //如果count表中day数据不为当天
                if(!GoodsDayCount::findOne(['day'=>$time])){
                    //实例化
                    $dc=new GoodsDayCount();
                    //给count值为1
                    $dc->count = 1;
                    //day为当前时间
                    $dc->day = $time;
                    //保存
                    $dc->save();
                }else{
                //为当天  找到当天 并跟新
                    $count=GoodsDayCount::findOne(['day'=>$time]);
                    //更新count
                    $count->count += 1;
                    //保存
                    $count->save();
                }
                //sn  找到count值
                $c=GoodsDayCount::findOne(['day'=>$time])->count;
                //拼接  用0补全,5位数,count个数
                $model->sn=$time.sprintf('%05s',$c);
                //保存
                $model->save();

                //保存内容
                $content->goods_id=$model->id;
                $content->save();


                //提示跳转
                \Yii::$app->session->setFlash('success','添加成功!');
                return $this->redirect(['goods/index']);
            }
        }
        $models=GoodsCategory::find()->asArray()->all();
        $models=Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models,'content'=>$content]);
    }

    //edit
    public function actionEdit($id)
    {
        //实例化goods
        $model=Goods::findOne(['id'=>$id]);
        $content=GoodsIntro::findOne(['goods_id'=>$id]);
//        var_dump($content);exit;
        //接收值
        $request=new Request();
        if($request->isPost){
            if($model->load($request->post()) && $model->validate() && $content->load($request->post()) && $content->validate()){
                //保存
                $model->inputtime=time();//添加时间

                //定义一个时间
                $time=date('Ymd',time());
                //如果count表中day数据不为当天
                if(!GoodsDayCount::findOne(['day'=>$time])){
                    //实例化
                    $dc=new GoodsDayCount();
                    //给count值为1
                    $dc->count = 1;
                    //day为当前时间
                    $dc->day = $time;
                    //保存
                    $dc->save();
                }else{
                    //为当天  找到当天 并跟新
                    $count=GoodsDayCount::findOne(['day'=>$time]);
                    //更新count
                    $count->count += 1;
                    //保存
                    $count->save();
                }
                //sn  找到count值
              //  $c=GoodsDayCount::findOne(['day'=>$time])->count;
                //拼接  用0补全,5位数,count个数
             //   $model->sn=$time.sprintf('%05s',$c);
                //保存
                $model->save();

                //保存内容
            //    $content->goods_id=$model->id;
                $content->save();


                //提示跳转
                \Yii::$app->session->setFlash('success','添加成功!');
                return $this->redirect(['goods/index']);
            }
        }
        $models=GoodsCategory::find()->asArray()->all();
        $models=Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models,'content'=>$content]);
    }



    public function actions() {
        return [
            //ueditor的配置
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],

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
                    //$action->output['fileUrl'] = $action->getWebUrl();
                    /* $action->getFilename(); // "image/yyyymmddtimerand.jpg"  文件名
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg" 网络地址
                    $action->getSavePath();*/ // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg" 物理地址

                    //上传图片到七牛云
                    $qiniu=\Yii::$app->qiniu;//实例化七牛云组件
                    $qiniu->uploadFile($action->getSavePath(),$action->getFilename());//上传到七牛云
                    $url=$qiniu->getLink($action->getFilename());//获取到url地址.
                    $action->output['fileUrl'] = $url;//将七牛云地址返回给前端js
                },
            ],
        ];
    }



    //del
    public function actionDel($id)
    {
        $model=Goods::findOne(['id'=>$id]);
        $model->status=0;
        $model->save();
        return $this->redirect(['goods/index']);
    }

    //回收
    public function actionRecycle()
    {
        $query=Goods::find()->where(['status'=>0]);
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('recycle',['models'=>$models,'pager'=>$pager]);
    }

    public function actionReedit($id)
    {
        $model=Goods::findOne(['id'=>$id]);
        $model->status=1;
        $model->save();
        \Yii::$app->session->setFlash('success','恢复成功!');
        return $this->redirect(['goods/recycle']);
    }

    public function actionRedel($id)
    {
        $model=Goods::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['goods/index']);
    }

    //相册添加
 /*   public function actionGallery($id)
    {
        //找到商品对应所有的图片
        $models=GoodsGallery::find()->where(['goods_id'=>$id])->all();
        return $this->render('gallery',['models'=>$models,'goods_id'=>$id]);
    }*/


    public function actionGallery($id)
    {
        $model=new GoodsGallery();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->goods_id=$id;
                $model->save();
            }
        }
        return $this->render('gallery',['model'=>$model]);
    }

    //相册列表
    public function actionGallerys($id)
    {
        $model=GoodsGallery::findOne(['goods_id'=>$id]);
        return $this->render('gallerys',['model'=>$model]);
    }

    public function actionDelgallery($id)
    {
        $model=GoodsGallery::findOne($id);
        $model->delete();
        $this->refresh();
    }
}
