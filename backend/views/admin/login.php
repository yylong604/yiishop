<?php
/**
 * 登录
 */
$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'username');
echo $from->field($model,'password')->passwordInput();
echo $from->field($model,'code')->widget(\yii\captcha\Captcha::className());
echo $from->field($model,'cook')->radio();
echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();