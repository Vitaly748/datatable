<?php

namespace app\assets;

use app\components\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Основной комплект ресурсов
 *
 * @package app\assets
 */
class MainAsset extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public $css = [
        'css/reset.css',
        'css/main.css',
    ];

    /**
     * @inheritDoc
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
