<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加',['admin/add'],['class'=>'btn btn-success','style'=>'float:right']);
?>
<h1>用户列表</h1>
<table class="table table-hover table-striped">
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>邮箱</th>
        <th>令牌</th>
        <th>令牌创建时间</th>
        <th>最后登录时间</th>
        <th>最后登录ip</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->username?></td>
            <td><?=$model->email?></td>
            <td><?=$model->token?></td>
            <td><?=$model->token_create_time?></td>
            <td><?=date('Y-m-d H:m:s',$model->last_login_time)?></td>
            <td><?=$model->last_login_ip?></td>
            <td>
<!--                --><?php //echo \yii\bootstrap\Html::a('修改',['admin/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?php echo \yii\bootstrap\Html::a('删除',['admin/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
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