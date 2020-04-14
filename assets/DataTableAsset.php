<?php

namespace app\assets;

use app\components\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Комплект ресурсов для работы с виджетом DataTables
 *
 * @package app\assets
 *
 * @see https://datatables.net
 */
class DataTableAsset extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public $css = [
        'css/dataTables.css',
    ];

    /**
     * @inheritDoc
     */
    public $js = [
        'js/dataTables.js',
    ];

    /**
     * @inheritDoc
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
