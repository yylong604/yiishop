<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/2
 * Time: 21:03
 */

namespace backend\controllers;


use backend\models\GoodsGallery;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsGalleryController extends Controller
{

    public function actionAsyncBanner ()
    {
        // 商品ID
        $id = \Yii::$app->request->post('goods_id');

        // $p1 $p2是我们处理完图片之后需要返回的信息，其参数意义可参考上面的讲解
        $p1 = $p2 = [];
        // 如果没有商品图或者商品id非真，返回空
        if (empty($_FILES['GoodsGallery']['name']) || empty($_FILES['GoodsGallery']['name']['image']) || !$id) {
            echo '{}';
            return;
        }

        // 循环多张商品banner图进行上传和上传后的处理
        for ($i = 0; $i < count($_FILES['GoodsGallery']['name']['image']); $i++) {
            // 上传之后的商品图是可以进行删除操作的，我们为每一个商品成功的商品图指定删除操作的地址
            $url = '/goods-gallery/del';

            // 调用图片接口上传后返回的图片地址，注意是可访问到的图片地址哦
            $imageUrl = '';

            $model = new GoodsGallery();

            $model->image=UploadedFile::getInstances($model,'image')[0];
            //验证规则
                //判断图片是否存在
                      //生成文件路径
                      $file_name='upload/gallery/'.uniqid().'.'.$model->image->extension;

            //保存到属性上  false不删除临时文件
                      $model->image->saveAs($file_name,false);
                      //赋值给logo
                      $model->path='/'.$file_name;

            //保存到数据库
            // 保存商品banner图信息
            $model->goods_id = $id;
          //  $model->path = $imageUrl;
            $key = 0;
            if ($model->save(false)) {
                $key = $model->goods_id;
            }

            // 这是一些额外的其他信息，如果你需要的话
            // $pathinfo = pathinfo($imageUrl);
            // $caption = $pathinfo['basename'];
            // $size = $_FILES['Banner']['size']['banner_url'][$i];


            $p1[$i] = $imageUrl=$file_name;
            $p2[$i] = ['url' => $url, 'key' => $key];

        }

        // 返回上传成功后的商品图信息
        echo json_encode([
            'initialPreview' => $p1,
            'initialPreviewConfig' => $p2,
            'append' => true,
        ]);
        return;
    }





    public function actionAdd($id='')
    {
        $model=new GoodsGallery();
        $request=new Request();
        if($request->isPost){
            if($model->load($request->post()) && $model->validate()){
            }
        }
        $relationBanners = GoodsGallery::find()->where(['goods_id' => $id])->asArray()->all();
// @param $p1 Array 需要预览的商品图，是商品图的一个集合
// @param $p2 Array 对应商品图的操作属性，我们这里包括商品图删除的地址和商品图的id
        $p1 = $p2 = [];
        if ($relationBanners) {
            foreach ($relationBanners as $k => $v) {
                $p1[$k] = $v['path'];

                $p2[$k] = [
                    // 要删除商品图的地址
                    'url' => Url::toRoute('goods-gallery/del'),
                    // 商品图对应的商品图id
                    'key' => $v['id'],
                ];
            }
        }

        return $this->render('add', [
            // other params
            'p1' => $p1,
            'p2' => $p2,
            // 商品id
            'id' => $id,
            'model'=>$model,
        ]);
    }

    public function actionDel()
    {
        $id=$_POST['key'];
        var_dump($id);
        $model=GoodsGallery::findOne(['id'=>$id]);
        $model->delete();
       \Yii::$app->session->setFlash('删除成功!');
        return ['success'=>true];
    }
}