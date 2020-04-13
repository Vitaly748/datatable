<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Модель данных связки Пользовать-Навык
 *
 * @property int $id Идентификатор связки
 * @property int $user_id Идентификатор пользователя
 * @property int $skill_id Идентификатор навыка
 * @property string $created_at Дата создания связки
 * @property string $updated_at Дата редактирования связки
 *
 * @property-read User[] $users Список моделей данных пользователей текущей связки
 * @property-read Skill[] $skills Список моделей данных навыков текущей связки
 *
 * @package app\models
 */
class PvUserSkill extends ActiveRecord
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
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            [['skill_id'], 'exist', 'targetClass' => Skill::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * Получение объекта SQL-запроса для получения моделей данных пользователей текущей связки
     *
     * @return ActiveQuery Объект SQL-запроса
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id']);
    }

    /**
     * Получение объекта SQL-запроса для получения моделей данных навыков текущей связки
     *
     * @return ActiveQuery Объект SQL-запроса
     */
    public function getSkills(): ActiveQuery
    {
        return $this->hasMany(Skill::class, ['id' => 'skill_id']);
    }
}
