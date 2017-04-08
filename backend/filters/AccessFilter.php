<?php

namespace backend\filters;
/**
 * 权限
 */
class AccessFilter extends \yii\base\ActionFilter
{
    public function beforeAction($action)
    {
        //判断用户是否有当前路由的权限
        if(!\Yii::$app->user->can($action->uniqueId)){

            //如果没有登录
            if(\Yii::$app->user->isGuest){
                //跳转到登录页面
                return $action->controller->redirect(\Yii::$app->user->loginUrl);
            }

            //抛出异常
            throw new \yii\web\HttpException('403','没有权限!');
            return false;
        }
        return parent::beforeAction();
    }

}