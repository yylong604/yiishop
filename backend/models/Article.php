<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property string $inputtime
 */
class Article extends \yii\db\ActiveRecord
{
    public static $status_options=[1=>'正常','-1'=>'删除',0=>'隐藏'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'article_category_id','status','sort'], 'required'],
            [['article_category_id', 'status', 'sort', 'inputtime'], 'integer'],
            [['name', 'intro'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名称',
            'article_category_id' => '文章分类',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '添加时间',
        ];
    }

    //获取文章分类
    public static function getCategory_id()
    {
        //创建对象获取所以数据
        $category=ArticleCategory::find()->all();
        //遍历数组,以id和name对应的形式
        return ArrayHelper::map($category,'id','name');

    }

    //获取所属分类 1对1
    public function getCategory()
    {
        /*
         * 参数1:类名:
         * 参数2:关联表的主键=>关联表在当前表的字段
         */
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }

}
