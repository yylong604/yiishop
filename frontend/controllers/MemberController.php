<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;
use yii\web\Request;


class MemberController extends \yii\web\Controller
{
    //修改布局文件
    public $layout='login';

    public function actionIndex()
    {
//        $model=new Member();
        return $this->render('index');
    }




       public function actionRegist()
    {
        $model=new Member();

            if($model->load(\Yii::$app->request->post()) && $model->validate()){

                $model->add_time=time();
                $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
                $model->authkey = \Yii::$app->security->generateRandomString();
                $model->save(false);


                \Yii::$app->session->setFlash('注册成功!');
                return $this->redirect(['member/index']);
            }

        return $this->render('regist',['model'=>$model]);
    }

    //发送手机验证码
    public function actionSms()
    {
        $tel = \Yii::$app->request->post('tel');
        $code = rand(1000,9999);
        \Yii::$app->session->set('tel_'.$tel,$code);

        //发送验证码

        Member::sendMsg($tel,$code);
    }



    public function actionLogin()
    {
        $model=new LoginForm();
        $request = new Request();
        if($request->isPost){
           $model->load($request->post());
//            var_dump($model->checkLogin());exit;
            if($model->checkLogin()){
              //  $this->refresh();
//                \Yii::$app->session->setFlash('登录成功!');
                  return $this->redirect(['member/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
    }

    //阿里大于
    public function actionTest()
    {


// 配置信息
        $config = [
            'app_key'    => '23746965',
            'app_secret' => 'ca7d89e01785fa99fce67cfa427a1299',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];


// 使用方法一
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum('18009006213')
            ->setSmsParam([
                'content' => rand(1000,9999)
            ])
            ->setSmsFreeSignName('云淡风轻近午天')
            ->setSmsTemplateCode('SMS_60855272');

        $resp = $client->execute($req);
        var_dump($resp);
    }
}
