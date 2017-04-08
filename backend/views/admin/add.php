<?php
use yii\web\JsExpression;
use yii\bootstrap\Html;
use xj\uploadify\Uploadify;
/**
 * 用户
 */
echo \yii\bootstrap\Html::a('返回首页',['goods/index'],['class'=>'btn btn-info']);

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'email');
echo $form->field($model,'roles')->checkboxList(\backend\models\AdminForm::getRoleOptions());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();
