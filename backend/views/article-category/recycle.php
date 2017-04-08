<?php
/**
 * 回收站
 */
echo \yii\bootstrap\Html::a('首页',['article-category/index'],['class'=>'btn btn-success','style'=>'float:right']);

?>
    <h1>回收站</h1>
    <table class="table table-hover">
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
                <td><?=\backend\models\ArticleCategory::$help[$model->is_help]?></td>
                <td>
                    <?php echo \yii\bootstrap\Html::a('恢复',['article-category/reback','id'=>$model->id],['class'=>'btn btn-info'])?>
                    <?php echo \yii\bootstrap\Html::a('清除',['article-category/redel','id'=>$model->id],['class'=>'btn btn-danger'])?>
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
