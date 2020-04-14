<?php

namespace app\controllers;

use app\models\search\UserSearch;
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
     * @return string Html-код страницы
     */
    public function actionIndex(): string
    {
        $userSearch = new UserSearch();

        return $this->render('index', ['userSearch' => $userSearch]);
    }
}
