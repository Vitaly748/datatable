<?php

namespace app\commands;

use app\models\User;
use Throwable;
use yii\console\Controller;

/**
 * Контроллер для инициализации тестовых данных
 *
 * @package app\commands
 */
class InitController extends Controller
{
    /**
     * Заполнение таблиц тестовыми данными
     *
     * @param int $userAmount Количество создаваемых пользователей. По умолчанию равно 10
     *
     * @throws Throwable
     */
    public function actionIndex(int $userAmount = 10): void
    {
        for ($counter = 0; $counter < $userAmount; $counter++) {
            User::createTestUser();
        }
    }
}
