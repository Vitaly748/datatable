<?php

namespace app\assets;

use app\components\web\AssetBundle;

/**
 * Комплект ресурсов главной страницы
 *
 * @package app\assets
 */
class IndexAsset extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public $js = [
        'js/index.js',
    ];

    /**
     * @inheritDoc
     */
    public $depends = [
        MainAsset::class,
    ];
}
