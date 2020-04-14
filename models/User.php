<?php

namespace app\models;

use app\helpers\ModelHelper;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\ServerErrorHttpException;

/**
 * Модель данных пользователя
 *
 * @property int $id Идентификатор пользователя
 * @property string $name Имя пользователя
 * @property int $city_id Идентификатор города
 * @property string $created_at Дата создания пользователя
 * @property string $updated_at Дата редактирования пользователя
 *
 * @property-read City $city Модель данных города текущего пользователя
 * @property-read PvUserSkill[] $pvUserSkills Список моделей данных связок Пользовать-Навык текущего пользователя
 * @property-read Skill[] $skills Список моделей данных навыков текущего пользователя
 *
 * @package app\models
 */
class User extends ActiveRecord
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
            [['city_id'], 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'city_id' => 'Город',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
    }

    /**
     * Получение объекта SQL-запроса для получения модели данных города текущего пользователя
     *
     * @return ActiveQuery Объект SQL-запроса
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Получение объекта SQL-запроса для получения моделей данных связок Пользовать-Навык текущего пользователя
     *
     * @return ActiveQuery Объект SQL-запроса
     */
    public function getPvUserSkills(): ActiveQuery
    {
        return $this->hasMany(PvUserSkill::class, ['user_id' => 'id']);
    }

    /**
     * Получение объекта SQL-запроса для получения моделей данных навыков текущего пользователя
     *
     * @return ActiveQuery Объект SQL-запроса
     *
     * @throws InvalidConfigException
     */
    public function getSkills(): ActiveQuery
    {
        return $this->hasMany(Skill::class, ['id' => 'skill_id'])->viaTable('{{%pv_user_skill}}', ['user_id' => 'id']);
    }

    /**
     * Создание тестового пользователя
     *
     * @return User Модель данных созданного пользователя
     *
     * @throws Throwable
     */
    public static function createTestUser(): User
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user = new static();
            $user->attributes = [
                'name' => ModelHelper::getRandomUserName(),
                'city_id' => ModelHelper::getRandomCityId(),
            ];

            if (!$user->save()) {
                throw new ServerErrorHttpException('Не удалось сохранить модель данных пользователя');
            }

            $skillIds = ModelHelper::getRandomSkillIds();

            foreach ($skillIds as $skillId) {
                $pvUserSkill = new PvUserSkill();

                $pvUserSkill->attributes = [
                    'user_id' => $user->id,
                    'skill_id' => $skillId,
                ];

                if (!$pvUserSkill->save()) {
                    throw new ServerErrorHttpException('Не удалось сохранить модель данных связки Пользовать-Навык');
                }
            }

            $transaction->commit();
        } catch (Throwable $exception) {
            $transaction->rollBack();

            throw $exception;
        }

        return $user;
    }
}
