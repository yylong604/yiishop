<?php
/**
 * 添加菜单
 */
$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'parent_id')->dropDownList(\backend\models\Menu::getParent_id());
echo $from->field($model,'url');
echo $from->field($model,'name');
echo $from->field($model,'description');
echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();