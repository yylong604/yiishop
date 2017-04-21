<?php
/*
 * 静态资源管理器:加载静态资源
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main frontend application asset bundle.
 */
class ListAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/list.css',
        'style/common.css',
        'style/bottomnav.css',
        'style/footer.css',
    ];
    public $js = [
        'js/header.js',
        'js/list.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
