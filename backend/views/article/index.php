<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-success']);
?>
<h1>文章列表</h1>
<table class="table tabel-hover table-striped">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>所属分类</th>
        <th>状态</th>
        <th>排序</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->category->name?></td>
            <td><?=\backend\models\Article::$status_options[$model->status]?></td>
            <td><?=$model->sort?></td>
            <td><?= date("Y-m-d H:m:s",$model->inputtime)?></td>
            <td>
                <?= \yii\bootstrap\Html::a('编辑',['article/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?= \yii\bootstrap\Html::a('删除',['article/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
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

