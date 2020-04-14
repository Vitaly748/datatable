<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Модель данных навыка
 *
 * @property int $id Идентификатор навыка
 * @property string $name Название навыка
 * @property string $created_at Дата создания навыка
 * @property string $updated_at Дата редактирования навыка
 *
 * @property-read PvUserSkill[] $pvUserSkills Список моделей данных связок Пользовать-Навык текущего навыка
 * @property-read User[] $users Список моделей данных пользователей текущего навыка
 *
 * @package app\models
 */
class Skill extends ActiveRecord
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
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
    }

    /**
     * Получение объекта SQL-запроса для получения моделей данных связок Пользовать-Навык текущего навыка
     *
     * @return ActiveQuery Объект SQL-запроса
     */
    public function getPvUserSkills(): ActiveQuery
    {
        return $this->hasMany(PvUserSkill::class, ['skill_id' => 'id']);
    }

    /**
     * Получение объекта SQL-запроса для получения моделей данных пользователей текущего навыка
     *
     * @return ActiveQuery Объект SQL-запроса
     *
     * @throws InvalidConfigException
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('{{%pv_user_skill}}', ['skill_id' => 'id']);
    }
}
