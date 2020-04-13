<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Модель данных города
 *
 * @property int $id Идентификатор города
 * @property string $name Название города
 * @property string $created_at Дата создания города
 * @property string $updated_at Дата редактирования города
 *
 * @property-read User[] $users Список моделей данных пользователей текущего города
 *
 * @package app\models
 */
class City extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('CURRENT_TIMESTAMP'),
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * Получение объекта SQL-запроса для получения моделей данных пользователей текущего города
     *
     * @return ActiveQuery Объект SQL-запроса
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['city_id' => 'id']);
    }
}
