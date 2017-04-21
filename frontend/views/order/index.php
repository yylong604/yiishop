<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
    <form action="<?=\yii\helpers\Url::to(['order/order'])?>" method="post" name="form1">
<!--    --><?php //$form = \yii\widgets\ActiveForm::begin();?>
    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息 <a href="javascript:" id="address_modify">[修改]</a></h3>
            <div class="address_info">
                <p>
                    <?php foreach($models as $address):?>
                    <input type="radio" value="<?=$address->id?>" name="address_id"/><?=$address->name.' '.$address->tel .' '. $address->province.' '. $address->city.' '. $address->area.' '.  $address->address; ?></p>
                <?php endforeach?>
            </div>


            <div class="address_select ">

            </div>
        </div>
        <!-- 收货人信息  end-->


        <div class="delivery">
            <h3>送货方式 <a href="javascript:;" id="delivery_modify">[修改]</a></h3>
            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach(\frontend\models\Order::$deliveries as $i=>$delivery):?>
                        <tr>
                            <td><input type="radio" name="delivery_id" class="delivery_name" value="<?=$i?>"/><?=$delivery[0]?></td>
                            <td class="delivery_price"><?=$delivery[1]?></td>
                            <td><?=$delivery[2]?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <!--                <a href="" class="confirm_btn"><span>确认送货方式</span></a>-->
            </div>
        </div>



        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 <a href="javascript:;" id="pay_modify">[修改]</a></h3>
            <div class="pay_info">
                <p>
<!--                    --><?php //foreach($pay_types as $pay_type):
//
//                        var_dump($pay_type);exit;?>
<!--                    <input type="radio" value="1" name="pay_type_id"/>--><?//=$pay_type?>
<!--                    --><?php //endforeach?>
                    <?php foreach(\frontend\models\Order::$payments as $id=>$payment):?>
                        <tr class="">
                            <p>
                            <td class="col1"><input type="radio" value="<?=$id?>" name="pay_type_id"><?=$payment[0]?></td>
                            <td class="col2"><?=$payment[1]?></td>
                            </p>
                        </tr>
                    <?php endforeach;?>
                </p>
            </div>

            <div class="pay_select none">
                <table>
                    <tr class="cur">
                        <td class="col1"><input type="radio" name="pay" />货到付款</td>
                        <td class="col2">送货上门后再收款，支持现金、POS机刷卡、支票支付</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" />在线支付</td>
                        <td class="col2">即时到帐，支持绝大数银行借记卡及部分银行信用卡</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" />上门自提</td>
                        <td class="col2">自提时付款，支持现金、POS刷卡、支票支付</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" />邮局汇款</td>
                        <td class="col2">通过快钱平台收款 汇款后1-3个工作日到账</td>
                    </tr>
                </table>
                <a href="" class="confirm_btn"><span>确认支付方式</span></a>
            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <div class="receipt">
            <h3>发票信息 <a href="javascript:;" id="receipt_modify">[修改]</a></h3>
            <div class="receipt_info">
                <p>个人发票</p>
                <p>内容：明细</p>
            </div>


        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <?=\frontend\widgets\GoodsListWidget::widget()?>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

<!--    <div class="fillin_ft">-->
<!--        <a href=""><span>提交订单</span></a>-->
<!--<!--        <p >应付总额：<strong class="total_pay"></strong></p>-->-->
<!--        <p>应付总额：<strong >￥<span class="total_pay"></span>元</strong></p>-->
<!---->
<!---->
<!--    </div>-->
<div class="fillin_ft">
    <a href="javascript:document.form1.submit();"><span>提交表单</span></a>
<!--    --><?//= \yii\helpers\Html::submitButton()?>
    <p>应付总额：<strong >￥<span class="total_pay"></span>元</strong></p>

<?php //\yii\widgets\ActiveForm::end()?>
</div>
</form>

<!-- 主体部分 end -->

