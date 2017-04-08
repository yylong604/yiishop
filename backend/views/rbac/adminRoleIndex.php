<?php
/**
 * 角色列表
 */
echo \yii\bootstrap\Html::a('给用户关联角色',['rbac/admin-role-add']);
?>
<table class="table">
    <tr>
        <td>角色名</td>
        <td>描述</td>
        <td>操作</td>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?= $model->name?></td>
            <td><?= $model->description?></td>
            <td><!--
                <?/*= \yii\bootstrap\Html::a('修改',['rbac/admin-role-edit','name'=>$model->name])*/?>
                <?/*= \yii\bootstrap\Html::a('删除',['rbac/admin-role-del','name'=>$model->name])*/?>
            --></td>
        </tr>
    <?php endforeach?>
</table>
