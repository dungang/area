<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/1
 * Time: 10:44
 */

namespace huluwa\area\assets;


use yii\web\AssetBundle;

class AreaAsset extends AssetBundle
{
    public $pluginName = 'area';
    public $sourcePath = "@vendor/dungang/area/assets/js";

    public $js = [
        'area.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}