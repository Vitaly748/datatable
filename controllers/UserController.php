<?php

namespace app\controllers;

use app\models\search\UserSearch;
use app\models\User;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Контроллер по работе с пользователями
 *
 * @package app\controllers
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public $enableCsrfValidation = true;

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);

        return $behaviors;
    }

    /**
     * Поиск пользователей
     *
     * @return array Ассоциативный массив с результатом выполнения
     *
     * @throws BadRequestHttpException
     */
    public function actionGet(): array
    {
        $post = Yii::$app->request->post();
        $userSearch = new UserSearch();

        $userSearch->attributes = [
            'searchText' => ArrayHelper::getValue($post, ['search', 'value']),
            'offset' => ArrayHelper::getValue($post, ['start'], 0),
            'limit' => ArrayHelper::getValue($post, ['length'], 0),
            'sortAttribute' => UserSearch::getSortAttributeByNumber(ArrayHelper::getValue($post, ['order', 0, 'column'])),
            'sortType' => ArrayHelper::getValue($post, ['order', 0, 'dir']) === 'desc' ? SORT_DESC : SORT_ASC,
        ];

        if (!$userSearch->validate()) {
            throw new BadRequestHttpException('Некорректный запрос');
        }

        $dataProvider = $userSearch->search();

        return array_merge($this->formUserGetData($dataProvider), [
            'draw' => $post['draw'] ?? 0,
        ]);
    }

    /**
     * Добавление случайного пользователя
     *
     * @return array Ассоциативный массив с результатом выполнения
     */
    public function actionAdd(): array
    {
        try {
            User::createTestUser();
        } catch (Throwable $exception) {
        }

        return [
            'success' => !isset($exception),
            'error' => isset($exception) ? $exception->getMessage() : null,
        ];
    }

    /**
     * Удаление пользователя
     *
     * @return array Ассоциативный массив с результатом выполнения
     */
    public function actionDelete(): array
    {
        try {
            $userId = Yii::$app->request->post('id');

            if (!$userId) {
                throw new BadRequestHttpException('Не задан идентификатор пользователя');
            }

            if (!$user = User::findOne($userId)) {
                throw new NotFoundHttpException('Пользователь не найден');
            }

            if (!$user->delete()) {
                throw new ServerErrorHttpException('Ошибка при удалении пользователя');
            }
        } catch (Throwable $exception) {
        }

        return [
            'success' => !isset($exception),
            'error' => isset($exception) ? $exception->getMessage() : null,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function verbs()
    {
        return [
            'get' => ['POST'],
            'add' => ['POST'],
            'delete' => ['POST'],
        ];
    }

    /**
     * Формирование структуры данных с информацией о пользователях
     *
     * @param ActiveDataProvider $dataProvider Провайдер данных
     *
     * @return array Ассоциативный массив с данными
     */
    protected function formUserGetData(ActiveDataProvider $dataProvider): array
    {
        $data = [
            'recordsFiltered' => $dataProvider->totalCount,
            'data' => $dataProvider->models,
        ];

        $dataProvider->query->where(null);
        $dataProvider->totalCount = null;
        $data['recordsTotal'] = $dataProvider->totalCount;

        return $data;
    }
}
