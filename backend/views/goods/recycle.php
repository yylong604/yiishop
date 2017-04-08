<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('首页',['goods/index'],['class'=>'btn btn-success'])
?>
    <h1>回收站</h1>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>货号</th>
            <th>图片</th>
            <th>分类</th>
            <th>品牌</th>
            <th>市场售价</th>
            <th>本店售价</th>
            <th>库存</th>
            <th>上架</th>
            <th>状态</th>
            <th>排序</th>
            <th>录入时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($models as $model):?>
            <tr>
                <td><?=$model->id?></td>
                <td><?=$model->name?></td>
                <td><?=$model->sn?></td>
                <td><?php echo \yii\bootstrap\Html::img($model->logoUrl(),['width'=>'50px'])?></td>
                <td><?=$model->goods_category_id?></td>
                <td><?=$model->brand_id?></td>
                <td><?=$model->market_price?></td>
                <td><?=$model->shop_price?></td>
                <td><?=$model->stock?></td>
                <td><?= \backend\models\Goods::$sale_options[$model->is_on_sale]?></td>
                <td><?= \backend\models\Goods::$status_options[$model->status]?></td>
                <td><?=$model->sort?></td>
                <td><?=$model->inputtime?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('恢复',['goods/reedit','id'=>$model->id],['class'=>'btn btn-info'])?>
                    <?=\yii\bootstrap\Html::a('删除',['goods/redel','id'=>$model->id],['class'=>'btn btn-danger'])?>
                </td>
            </tr>
        <?php endforeach?>
    </table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'firstPageLabel'=>'首页',
    'lastPageLabel'=>'最后页',
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);