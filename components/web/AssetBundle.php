<?php

namespace app\components\web;

use yii\web\AssetBundle as BaseAssetBundle;
use yii\web\View;

/**
 * Базовый комплект ресурсов
 *
 * @package app\components\web
 */
class AssetBundle extends BaseAssetBundle
{
    /**
     * @inheritDoc
     */
    public $basePath = '@webroot';

    /**
     * @inheritDoc
     */
    public $baseUrl = '@web';

    /**
     * @inheritDoc
     */
    public $jsOptions = ['position' => View::POS_HEAD];
}
