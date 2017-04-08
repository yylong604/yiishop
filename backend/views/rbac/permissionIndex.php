<?php
/**
 * 角色列表
 */
echo \yii\bootstrap\Html::a('添加',['rbac/permission-add']);
?>
<table class="table">
    <tr>
        <td>权限名</td>
        <td>描述</td>
        <td>操作</td>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?= $model->name?></td>
            <td><?= $model->description?></td>
            <td>
                <?= \yii\bootstrap\Html::a('删除',['rbac/permission-del','name'=>$model->name])?>
            </td>
        </tr>
    <?php endforeach?>
</table>
