<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/29
 * Time: 12:51
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getCategory_id());
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Article::$status_options);
echo $form->field($model,'sort');
echo $form->field($ad_model,'content')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
