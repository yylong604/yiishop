<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\AdminForm;
use backend\models\PermissionForm;
use backend\models\RoleForm;

class RbacController extends \yii\web\Controller
{
    /*
     * 添加权限:
     *   1.实例化表单模型()
     *   2.验证
     *   3.添加权限
     */
    //权限列表
    public function actionPermissionIndex()
    {
        //实例化rbac组件
        $authManager =  \Yii::$app->authManager;
        $models = $authManager->getPermissions();
        return $this->render('permissionIndex',['models'=>$models]);
    }

    //添加
    public function actionPermissionAdd()
    {
        //实例化表达模型
        $model=new PermissionForm();
        //实例化rbac组件
        $authManager=\Yii::$app->authManager;
        //判断提交方式并验证(表单模型中自定义验证规则,验证权限唯一性)
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //执行权限创建
            $permission = $authManager->createPermission($model->name);
            $permission->description=$model->description;
            //添加到权限表
            $authManager->add($permission);
            //提示跳转
            \Yii::$app->session->setFlash('success','添加权限成功!');
            $this->refresh();
        }
        //分配到页面
        return $this->render('addPermission',['model'=>$model]);
    }

    //删除
    public function actionPermissionDel($name)
    {
        $authManager= \Yii::$app->authManager;
        $permission=$authManager->getPermission($name);
        $authManager->remove($permission);
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['rbac/permission-index']);
    }



    /*
     * 添加角色
     */
    //展示列表
    public function actionRoleIndex()
    {
        //实例化rbac组件
        $authManager =  \Yii::$app->authManager;
        $models = $authManager->getRoles();
        return $this->render('roleIndex',['models'=>$models]);

    }

    //添加
    public function actionRoleAdd()
    {
        $model = new RoleForm();
        //实例化rbac组件
        $authManager =  \Yii::$app->authManager;
        //接收并验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //获得role的名称
            $role = $authManager->createRole($model->name);
            //获得描述
            $role->description=$model->description;
            //添加role
            $authManager->add($role);
            //遍历权限
            foreach($model->permission as $permission){
                $permission = $authManager->getPermission($permission);
                //给角色添加权限
                $authManager->addChild($role,$permission);
            }
            //添加成功 提示跳转
            \Yii::$app->session->setFlash('success','添加角色成功!');
            $this->refresh();
        }
        return $this->render('addRole',['model'=>$model]);
    }

    //修改
    public function actionRoleEdit($name)
    {
        $model = new RoleForm();
        //实例化rbac组件
        $authManager =  \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        $permissions = $authManager->getPermissionsByRole($role->name);
        $model->name=$role->name;
        $model->description=$role->description;
        $model->permission=array_keys($permissions);
//        var_dump(array_keys($permissions));exit;
        //接收并验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //获得role的名称
            //获得描述
            $role->description=$model->description;
            $authManager->update($role->name,$role);
            $authManager->removeChildren($role);
            //遍历权限
            foreach($model->permission as $permission){
                $permission = $authManager->getPermission($permission);
                //给角色添加权限
                $authManager->addChild($role,$permission);
            }
            //添加成功 提示跳转
            \Yii::$app->session->setFlash('success','添加更新成功!');
            return $this->redirect(['rbac/role-index']);
        }
        return $this->render('addRole',['model'=>$model]);
    }

    //删除
    public function actionRoleDel($name)
    {
        $authManager=\Yii::$app->authManager;
        $role = $authManager->getRole($name);
        $authManager->remove($role);
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['rbac/role-index']);
    }



    /*
     * 用户关联角色
     */
    public function actionAdminRoleIndex()
    {
        //实例化rbac组件
        $authManager =  \Yii::$app->authManager;
        $models = $authManager->getRoles();
        return $this->render('adminRoleIndex',['models'=>$models]);
    }

    //读取用户,添加角色
    public function actionAdminRoleAdd()
    {
        //实例化rbac组件
        $authManager =  \Yii::$app->authManager;
        //实例化表单模型
        $model=new AdminForm();
        //接收验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //根据表单数据获得角色
            $role = $authManager->getRole($model->role);
            //用户关联角色
            $authManager->assign($role,$model->username);
            //提示跳转
            \Yii::$app->session->setFlash('success','关联角色成功!');
            return $this->redirect(['rbac/admin-role-index']);
        }
       return $this->render('adminRoleAdd',['model'=>$model]);
    }

    //修改
    public function actionAdminRoleEdit($name)
    {
        //实例化rbac组件
        $authManager =  \Yii::$app->authManager;
        //实例化表单模型
        $model=new AdminForm();
        $model->role=array_keys($authManager->getChildRoles($name));
        $role=$authManager->getRole($name);
        $model->username=$role->name;
 //       var_dump($model);exit;
        //接收验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //根据表单数据获得角色
            $role = $authManager->getRole($model->role);
            $authManager->revokeAll($name);
            //用户关联角色
            $authManager->assign($role,$model->username);
            //提示跳转
            \Yii::$app->session->setFlash('success','关联角色成功!');
            $this->refresh();
            return $this->redirect(['rbac/admin-role-index']);
        }
        return $this->render('adminRoleAdd',['model'=>$model]);
    }

    //删除
    public function actionAdminRoleDel($name)
    {
        //实例化
        $authManager =  \Yii::$app->authManager;
        //根据name获取role
        $role=$authManager->getRole($name);
        //根据role获取id
        $id = $authManager->getUserIdsByRole($name);
        //把数组变成字符串 取得id
        $id2 = implode('',$id);
        //执行删除角色和用户id的关联
        $authManager->revoke($role,$id2);
       //提示跳转
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['rbac/admin-role-index']);

    }
}
