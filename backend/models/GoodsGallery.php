<?php

namespace backend\models;

use liyunfang\file\UploadBehavior;
use Yii;

/**
 * This is the model class for table "goods_gallery".
 *
 * @property string $id
 * @property string $goods_id
 * @property string $path
 */
class GoodsGallery extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
            [['image'], 'file','maxFiles' => 3, 'extensions' => ['jpg, png, gif'], 'on' => ['insert', 'update']],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'path' => '地址',
        ];
    }

    public function logoUrl()
    {
        if(strpos($this->path,'http://')===false){
            return '@web'.$this->path;
        }
        return $this->path;
    }


    public function behaviors()
    {
        return [
            [
                'class' => \liyunfang\file\UploadImageBehavior::className(),
                'attributes' => [
                    [
                        'attribute' => 'image',
                        'path' => '@webroot/upload/user/{id}',
                        'url' => '@web/upload/user/{id}',
                        //'multiple' => true,
                        //'multipleSeparator' => '|',
                        //'nullValue' => '',
                        //'instanceByName' => false,
                        //'generateNewName' => true,
                        //'unlinkOnSave' => true,
                        //'deleteTempFile' => true,
                        //'scenarios' => ['insert', 'update'],
                        //'createThumbsOnSave' => true,    //是否在保存时创建缩略图 默认true
                        //'createThumbsOnRequest' => true, //是否在请求图片时创建缩略图 默认false
                        // 'thumbs' => [
                        //    'thumb' => ['width' => 400, 'height' => 400,'quality' => 90],
                        //    'preview' => ['width' => 200, 'height' => 200],
                        //    ...
                        //],
                        //'placeholder' => '@app/modules/user/assets/images/userpic.jpg', //默认图片
                        'thumbPath' => '@webroot/upload/user/{id}/thumb',  //缩略图保存物理路径
                        'thumbUrl' => '@web/upload/user/{id}/thumb',   //缩略图访问地址
                    ],
                ],
                'scenarios' => ['insert', 'update'],
                //'multipleSeparator' => '|',
                //'nullValue' => '',
                //'instanceByName' => false,
                //'generateNewName' => true,
                //'unlinkOnSave' => true,
                //'deleteTempFile' => true,
                //'createThumbsOnSave' => true,       //如果属性中没有该配置则默认读取此配置
                //'createThumbsOnRequest' => false,  //如果属性中没有该配置则默认读取此配置
                // 'thumbs' => [
                //    'thumb' => ['width' => 400, 'height' => 400,'quality' => 90],
                //    'preview' => ['width' => 200, 'height' => 200],
                //],    //如果属性中没有该配置则默认读取此配置
            ],
        ];
    }
}
