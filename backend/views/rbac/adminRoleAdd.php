<?php
/**
 * 用户关联角色
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username')->dropDownList(\backend\models\AdminForm::getAdminOptions());
echo $form->field($model,'role')->checkboxList(\backend\models\AdminForm::getRoleOptions());
echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();
