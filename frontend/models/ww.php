<?php
$order->name = $address->name;

            $order->member_id = 1;
            $order->province = $address->province;
            $order->city = $address->city;
            $order->area = $address->area;
            $order->address = $address->address;
            $order->tel = $address->tel;
            $order->delivery_id = $data['delivery_id'];
            $a=Order::$deliveries;
            $order->delivery_name = $a[$data['delivery_id']][0];
            $order->delivery_price = $a[$data['delivery_id']][1];
            $order->pay_type_id = $data['pay_type_id'];
            $b=Order::$payments;
            $order->pay_type_name = $b[$data['pay_type_id']][0];
            $order->price=100;
            $order->status=1;
            $order->trade_no = date('Ymdhms',time());


            $order->create_time = time();
            var_dump($order->getErrors());exit;