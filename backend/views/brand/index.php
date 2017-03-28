<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('回收站',['brand/recycle'],['class'=>'btn btn-warning','style'=>'float:right']);
echo \yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-success','style'=>'float:right']);
?>
<h1>品牌分类</h1>
<table class="table table-hover table-striped">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>图片</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?php echo \yii\bootstrap\Html::img('@web'.$model->logo,['width'=>'50px'])?></td>
            <td><?=$model->sort?></td>
            <td><?=\app\models\Brand::$status_options[$model->status]?></td>
            <td>
                <?php echo \yii\bootstrap\Html::a('修改',['brand/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?php echo \yii\bootstrap\Html::a('删除',['brand/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
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