<?php
/**
 * 回收站
 */
echo \yii\bootstrap\Html::a('首页',['brand/index'],['class'=>'btn btn-success','style'=>'float:right']);

?>
    <h1>回收站</h1>
    <table class="table table-hover">
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
                    <?php echo \yii\bootstrap\Html::a('恢复',['brand/reback','id'=>$model->id],['class'=>'btn btn-info'])?>
                    <?php echo \yii\bootstrap\Html::a('清除',['brand/redel','id'=>$model->id],['class'=>'btn btn-danger'])?>
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
