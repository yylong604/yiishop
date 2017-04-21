<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 22:06
 */

namespace frontend\widgets;


use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\GoodsCategory;
use yii\base\Widget;
use yii\helpers\Html;

class ListWidget extends Widget
{
/*
 *
 *
 */
    public function run()
    {
        $html = '';
        $goods_cate = GoodsCategory::find()->where(['name'=>'家用电器'])->all();
        foreach($goods_cate as $goods){
                $html .= '<h2>'.$goods->name.'</h2>
				<div class="catlist_wrap">';
            foreach($goods->children as $good){
                $html .= '<div class="child">
						<h3 class="on"><b></b>'.$good->name.'</h3>';
                foreach($good->children as $cate){
                    $html .= '<ul>
							<li><a href="">'.$cate->name.'</a></li>
						</ul>
					</div>';
                }
            }
            $html .= '</div>';
        }

        $html = <<<HTML
<div class="list_left fl mt10">
			<!-- 分类列表 start -->
			<div class="catlist">
			{$html}
			</div>
	<div style="clear:both; height:1px;"></div>
</div>
HTML;

/*
 <!-- 分类列表 start -->
        <div class="catlist">
            <h2>电脑、办公</h2>
            <div class="catlist_wrap">
                <div class="child">
                    <h3 class="on"><b></b>电脑整机</h3>
                    <ul>
                        <li><a href="">笔记本</a></li>
                        <li><a href="">超极本</a></li>
                        <li><a href="">平板电脑</a></li>
                    </ul>
                </div>

                <div class="child">
                    <h3><b></b>电脑配件</h3>
                    <ul class="none">
                        <li><a href="">CPU</a></li>
                        <li><a href="">主板</a></li>
                        <li><a href="">显卡</a></li>
                    </ul>
                </div>

                <div class="child">
                    <h3><b></b>办公打印</h3>
                    <ul class="none">
                        <li><a href="">打印机</a></li>
                        <li><a href="">一体机</a></li>
                        <li><a href="">投影机</a></li>
                        </li>
                    </ul>
                </div>

                <div class="child">
                    <h3><b></b>网络产品</h3>
                    <ul class="none">
                        <li><a href="">路由器</a></li>
                        <li><a href="">网卡</a></li>
                        <li><a href="">交换机</a></li>
                        </li>
                    </ul>
                </div>

                <div class="child">
                    <h3><b></b>外设产品</h3>
                    <ul class="none">
                        <li><a href="">鼠标</a></li>
                        <li><a href="">键盘</a></li>
                        <li><a href="">U盘</a></li>
                    </ul>
                </div>
            </div>

            <div style="clear:both; height:1px;"></div>
        </div>*/



        return $html;
    }


}