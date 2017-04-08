<?php
/**
 * 上传相册
 */

use yii\web\JsExpression;
use yii\bootstrap\Html;
use xj\uploadify\Uploadify;

echo \yii\bootstrap\Html::a('返回首页',['goods/index'],['class'=>'btn btn-info']);

$form=\yii\bootstrap\ActiveForm::begin();
//echo $form->field($model,'img[]')->fileInput();

//七牛云上传图片
echo $form->field($model,'path')->hiddenInput();
//Remove Events Auto Convert
echo Html::img($model->path,['id'=>'img']);
//外部TAG
echo Html::fileInput('test', NULL, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data);
        console.debug(data.fileUrl);
        $("#goodsgallery-path").val(data.fileUrl);
        $("#img").attr("src",data.fileUrl);
    }
}
EOF
        ),
    ]
]);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();

