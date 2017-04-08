<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加',['goods-category/add'],['class'=>'btn btn-success']);
?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>操作</th>
    </tr>
    <tbody id="category">
    <?php foreach($models as $model):?>
        <tr data-tree="<?=$model->tree?>" data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>" >
            <td><?=$model->id?></td>
            <td>
                <?=str_repeat('－',$model->depth).$model->name?>
                <span class="glyphicon glyphicon-chevron-up expend" style="float: right"></span>
            </td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$model->id],['class'=>'btn-sm btn-info','style'=>'float:right'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$model->id],['class'=>'btn-sm btn-danger','style'=>'float:right'])?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>


<?php
$js=<<<EOT
$(".expend").click(function(){
    //切换图标
    $(this).toggleClass("glyphicon glyphicon-chevron-down");
    $(this).toggleClass("glyphicon glyphicon-chevron-up");

    var current_tr = $(this).closest("tr");
    var current_lft = parseInt(current_tr.attr("data-lft"));
    var current_rgt = parseInt(current_tr.attr("data-rgt"));
    var current_tree = parseInt(current_tr.attr("data-tree"));
    console.log(current_lft);
    console.log(current_rgt);
    console.log(current_tree);
    $("#category tr").each(function(){
        var lft = parseInt($(this).attr("data-lft"));
        var rgt = parseInt($(this).attr("data-rgt"));
        var tree = parseInt($(this).attr("data-tree"));
        //var lft = 3;
        //var rgt = 4;
        //var tree = 1;
        if(tree==current_tree && current_lft<lft && current_rgt>rgt){
        console.log(lft);
        console.log(rgt);
        console.log(tree);
           $(this).fadeToggle();
        }
    });
});
EOT;
$this->registerJs($js);
