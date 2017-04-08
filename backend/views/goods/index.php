<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn btn-success']);
echo \yii\bootstrap\Html::a('回收站',['goods/recycle'],['class'=>'btn btn-warning'])
?>
<h1>商品列表</h1>

<?php
$form=\yii\bootstrap\ActiveForm::begin([
        'method'=>'get',
        'action'=>\yii\helpers\Url::to(['goods/index']),
        'options'=>['class'=>'form-inline']
]);
echo $form->field($model,'name')->textInput(['placeholder'=>'商品名'])->label(false);
echo $form->field($model,'sn')->textInput(['placeholder'=>'货号'])->label(false);
echo $form->field($model,'minPrice')->textInput(['placeholder'=>'min＄'])->label(false);
echo $form->field($model,'maxPrice')->textInput(['placeholder'=>'max＄'])->label(false);
echo \yii\bootstrap\Html::submitButton('搜索');
\yii\bootstrap\ActiveForm::end();
?>

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
            <td><?=date('Y-m-d/H:m:s',$model->inputtime)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('相册',['goods-gallery/add','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('编辑',['goods/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
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