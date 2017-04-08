<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 9:49
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name','description'],'required'],
            [['name'],'validateName'],
        ];
    }

    /*
     * 自定义验证方法
     */
    public function validateName($attribute,$params)
    {
        $authManager=\Yii::$app->authManager;

        if($authManager->getPermission($this->attributes)){
            $this->addError($attribute,'权限已经存在,请勿重复创建!');
        }
    }


    public function attributeLabels()
    {
        return [
            'name'=>'权限名(路由)',
            'description'=>'描述',
        ];
    }


}