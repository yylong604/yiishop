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
class GoodsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/goods.css',
        'style/common.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/jqzoom.css'
    ];
    public $js = [
        'js/header.js',
        'js/goods.js',
        'js/jqzoom-core.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
