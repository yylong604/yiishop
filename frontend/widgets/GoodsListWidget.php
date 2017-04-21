<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2017/4/14
 * Time: 18:57
 */

namespace frontend\widgets;


use frontend\models\Cart;
use yii\base\Widget;

class GoodsListWidget extends Widget
{
    public function run()
    {
        $html = '';
        $user_id = \Yii::$app->user->id;
        $total = 0;
        $total_price = 0;
        $goods = Cart::find()->where(['user_id'=>$user_id])->all();
        foreach($goods as $good){
            $html .= '<tr>
                    <td class="col1"><a href=""><img src="'.$good->goods->logo.'" </a>  <strong><a href="">'.$good->goods->name.'</a></strong></td>
                    <td class="col3"> ￥'.$good->goods->shop_price.'</td>
                    <td class="col4">'.$good->count.'</td>
                    <td class="col5"><span>￥'.($good->goods->shop_price)*($good->count).'</span></td>
                    </tr>';
            $total += ($good->count);
            $total_price += (($good->goods->shop_price)*($good->count));
        }
        $html .= '</tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul>
                                <li>
                                    <span>'.$total.' 件商品，总商品金额：</span>
                                    <em >￥<span id="goods_total_parice">'.$total_price.'</span></em>
                                </li>
                                <li>
                                    <span>返现：</span>
                                    <em>-￥</em>
                                </li>
                                <li>
                                    <span>运费：</span>
                                    <em id="delivery_price">￥</em>
                                </li>
                                <li>
                                    <span>应付总额：</span>
                                    <em >￥<span class="total_pay_price"></span></em>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    </tfoot>';
        return $html;
    }
}