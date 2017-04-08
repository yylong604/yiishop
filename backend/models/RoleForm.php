<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 9:49
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    public $name;
    public $description;
    public $permission;
    //定义场景
    const SCENARIO_ADD = 'add';

    public function rules()
    {
        return [
            [['name','description'],'required'],
            [['name'],'validateName','on'=>self::SCENARIO_ADD],//使用场景
            [['permission'],'safe'],
        ];
    }

    public function scenarios()
    {
        $scenarios=parent::scenarios();
        return ArrayHelper::merge(
            $scenarios,
            [
                self::SCENARIO_ADD=>['name','validateName','permission']
            ]
        );
    }
    /*
     * 自定义验证方法
     */
    public function validateName($attribute,$params)
    {
        $authManager=\Yii::$app->authManager;

        if($authManager->getRole($this->attributes)){
            $this->addError($attribute,'角色已经存在,请勿重复创建!');
        }
    }


    public function attributeLabels()
    {
        return [
            'name'=>'角色名',
            'description'=>'描述',
            'permission'=>'权限',
        ];
    }

    public static function getPermissionOptions()
    {
        //获取所以权限
        $authManager=\Yii::$app->authManager;
        $permissions = $authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');
    }
}