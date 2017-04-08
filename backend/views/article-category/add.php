<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/29
 * Time: 12:51
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status')->radioList(\backend\models\ArticleCategory::$status_options);
echo $form->field($model,'sort');
echo $form->field($model,'is_help')->dropDownList([1=>'帮助',0=>'不帮助']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
