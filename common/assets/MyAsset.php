<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MyAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@frontend/web';
    /**
     * @var array
     */
    public $js = [
        'js/my.js'
    ];

    public $css = [
      'css/my.css'
    ];
}
