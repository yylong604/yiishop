<?php

namespace frontend\components;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/14
 * Time: 19:27
 */
class CartCookieHandler extends \yii\base\Component
{
    private $_cart = [];
    public function __construct()
    {
        $cookies = \Yii::$app->request->cookies;
        if($cookies == null){

        }else{

        }
        return $this;
    }

    public function addCart()
    {

    }

    public function updateCart()
    {

    }

    public function delCart()
    {

    }

    public function save()
    {

    }
}