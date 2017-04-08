<?php
/**
 * 文章分类
 */
echo \yii\bootstrap\Html::a('添加',['article-category/add'],['class'=>'btn btn-success']);
echo \yii\bootstrap\Html::a('回收站',['article-category/recycle'],['class'=>'btn btn-warning']);
?>
<h1>文章分类</h1>
<table class="table table-hover table-striped">
    <tr>
        <th>ID</th>
        <th>分类名称</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>是否是帮助</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?= \backend\models\ArticleCategory::$status_options[$model->status]?></td>
            <td><?=$model->sort?></td>
            <td><?= \backend\models\ArticleCategory::$help[$model->is_help]?></td>
            <td>
                <?= \yii\bootstrap\Html::a('编辑',['article-category/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?= \yii\bootstrap\Html::a('删除',['article-category/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
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
