<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * Контроллер главной страницы
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * Отображение главной страницы
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
