<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\web\HttpException;

class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'order';




    /*
    * 订单确认提交页
    */

    public function actionOrder(){
        $model = new Order();
        $data = $_POST;
//       var_dump($data);exit;
        if(\Yii::$app->request->isPost){
            $model->member_id = \Yii::$app->user->id;
            $address = Address::findOne(['id'=>$data['address_id']]);
//            var_dump($address);exit;
            if($address==null){
                throw new HttpException('404','地址不存在');
            }
//            $order->name = $address->name;
//            $order->member_id = 1;
//            $order->province = $address->province;
//            $order->city = $address->city;
//            $order->area = $address->area;
//            $order->address = $address->address;
//            $order->tel = $address->tel;
//            $order->delivery_id = $data['delivery_id'];
//            $a=Order::$deliveries;
//            $order->delivery_name = $a[$data['delivery_id']][0];
//            $order->delivery_price = $a[$data['delivery_id']][1];
//            $order->pay_type_id = $data['pay_type_id'];
//            $b=Order::$payments;
//            $order->pay_type_name = $b[$data['pay_type_id']][0];
//            $order->price=100;
//            $order->status=1;
//            $order->trade_no = date('Ymdhms',time());
//
//
//            $order->create_time = time();
//            var_dump($order->getErrors());exit;
            $address = Address::findOne(['id'=>$data['address_id']]);
            //获取值并赋值
            $model->name = $address->name;//
            $model->province = $address->province;//
            $model->city = $address->city;//
            $model->area = $address->area;//
            $model->address = $address->address;//
            $model->tel = $address->tel;//
            //获取当前用户id
//            $model->member_id = \Yii::$app->user->id;
            $model->member_id = \Yii::$app->user->id;//
            //获取模型中配送方式数据 并赋值
            $d = $model::$deliveries;
            $model->delivery_id = $data['delivery_id'];//
            $model->delivery_name = $d[$data['delivery_id']][0];//
            $model->delivery_price = $d[$data['delivery_id']][1];//
            //获取支付数据
            $pay = $model::$payments;
            $model->pay_type_id = $data['pay_type_id'];//
            $model->pay_type_name = $pay[$data['pay_type_id']][0];//
            $model->price = 100;//
            //获取交易号信息

            $model->status = 1;//
            $model->trade_no = date('Ymdhms',time());//
            //获取时间
            $model->create_time = time();
//           $model->save();exit;

            //获取商品总价格
            $order_total_price = $model->delivery_price;

//            $db = \Yii::$app->db;
//            $transaction = $db->beginTransaction();//开启事务
//            try {
//                $model->save();
//
//                //订单详情
//                $carts = Cart::find()->where((['member_id'=>\Yii::$app->user->id]))->all();
//                foreach($carts as $cart){
//                    $order_detail = new OrderDetail();
//                    $order_detail->order_info_id = $model->id;
//                    $order_detail->goods_id = $cart->goods_id;
//                    $order_detail->goods_name = $cart->goods->name;
//                    $order_detail->logo = $cart->goods->logo;
//                    $order_detail->price = $cart->goods->shop_price;
//                    $order_detail->amount = $cart->amount;
//
//                    //检查库存
//                    if($cart->amount > $cart->goods->stock){
//                        //抛出异常
//                        throw new Exception('库存不足');
//                    }
//                    $order_detail->total_price = ($cart->goods->shop_price)*($cart->amount);
//                    $order_total_price += $order_detail->total_price;
//                    $model->price = $order_total_price;
//                    $order_detail->save();
//                    $model->save();
//                    //提交事物
//                    $transaction->commit();
//                }
//            }catch(Exception $e){
//                $transaction->rollBack();//回滚事物
//                \Yii::$app->session->setFlash('danger','商品的库存不足');
//            }
//        }
////        $addresses = Address::find()->all();
////        return $this->render('index',['addresses'=>$addresses]);
            $db = \Yii::$app->db;
            $transactions =  $db->beginTransaction();
            try{
                //保存到order表
                $model->save();


                //获取当前用户购物车里的商品id
                $goods_id = Cart::find()->where(['user_id' => \Yii::$app->user->id])->asArray()->all();
                //遍历商品id 查询商品数据
                foreach ($goods_id as $goodsinfo) {
                    //实例化订单表 (循环每次都需要实例化-->注意!)
                    $detial = new OrderDetail();
                    //根据遍历出的id到goods表取出值
                    $goods = Goods::find()->where(['id' => $goodsinfo['goods_id']])->one();
                    //一一赋值
                    $detial->goods_name = $goods->name;
                    $detial->logo = $goods->logo;
                    $detial->price = $goods->shop_price;
                    //order_info_id为订单表保存后的id
                    $detial->order_info_id = $model->id;
                    $detial->goods_id = $goods->id;
                    //判断如果购物车数量大于商品库存
                    if ($goodsinfo['count'] > $goods->stock) {
                        //抛出异常
                        throw new Exception('商品' . $goods->name . '数量不足!');
                    }else{
                        //否则修改商品数量:库存-购物车数量
                        $goods->stock = $goods->stock - $goodsinfo['count'];
                        $goods->save(false);
                    }
                    //数量为cart表里的数量
                    $detial->amount = $goodsinfo['count'];
                    //总价为商品的单价*数量
                    $detial->total_price = $goods->shop_price * $goodsinfo['count'];
                    //保存到detial
                    $detial->save();
                    $transactions->commit();
                }
                //捕获异常
            }catch (Exception $e){
                //回滚
                $transactions->rollBack();
                \Yii::$app->session->setFlash('danger','商品数量不足!');
            }


            //保存成功后删除当前用户的购物车数据
            Cart::deleteAll(['user_id'=>\Yii::$app->user->id]);
        }

        //定义空数组容器
//        $goods = [];
//        $carts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        $models = Address::find()->all();
//
//        //遍历购物车数据
//        foreach($carts as $goods_id=>$num){
//            //根据遍历的商品id获取商品信息,并以数组形式输出
//            $datas = Goods::find()->where(['id'=>$num->goods_id])->asArray()->one();
//            //在datas中定义字段保存商品数量
//            $datas['num'] = $num->count;
//            //放到空数组里
//            $goods[] = $datas;
//        }
        //分配数据到页面
        return $this->render('index',['models'=>$models]);
    }




}
