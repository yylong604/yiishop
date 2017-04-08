<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/30
 * Time: 14:41
 */

namespace backend\components;


use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class GoodsCategoryQuery extends ActiveQuery
{
    //使用多个树模式取消treeattribute阵列关键在behaviors()方法。配置查询类如下
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}