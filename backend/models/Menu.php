<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $url
 * @property string $name
 * @property string $description
 */
class Menu extends \yii\db\ActiveRecord
{

    public static function getParent_id()
    {
        //获取所有id为1 的分类  --二维数组
        $options=Menu::find(['parent_id'=>1])->asArray()->all();
        //添加一个顶级分类  --生成一个二维数组
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        //合并数组
        $menus = array_merge($models,$options);
        //返回值
        return ArrayHelper::map($menus,'id','name');
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['url', 'name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '上级菜单',
            'url' => '路由',
            'name' => '名称',
            'description' => '描述',
        ];
    }

    /*
     * 上 下级菜单 一对多关系
     */
    public function getChilden()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}
