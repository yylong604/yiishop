<?php
/**
 * 相册
 */
echo \yii\bootstrap\Html::a('返回首页',['goods/index'],['class'=>'btn btn-info']);
?>
<table class="table table-bordered">
    <tr>
        <td><?= \yii\bootstrap\Html::img($model->logoUrl())?></td>
        <td>
            <?= \yii\bootstrap\Html::a('添加图片',['goods/gallery','id'=>$model->goods_id],['class'=>'btn btn-success']); ?>
            <?= \yii\bootstrap\Html::a('删除',['goods/delgallery','id'=>$model->goods_id],['class'=>'btn btn-danger']); ?>
        </td>
    </tr>
</table>
