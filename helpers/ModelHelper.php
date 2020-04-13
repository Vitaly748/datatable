<?php

namespace app\helpers;

use app\models\City;
use app\models\Skill;
use Exception;
use Yii;

/**
 * Класс вспомогательных функций для работы с моделями данных
 *
 * @package app\helpers
 */
class ModelHelper
{
    /**
     * @var string Псевдоним пути файла, содержащего тестовые имена пользователей
     */
    public const ALIAS_USER_NAMES = '@app/data/user_names.txt';

    /**
     * @var int Максимальное количество навыков у одного пользователя
     */
    public const MAX_SKILL_AMOUNT = 6;

    /**
     * Получение случайного имени пользователя
     *
     * @return string Имя
     *
     * @throws Exception
     */
    public static function getRandomUserName(): string
    {
        $names = file(Yii::getAlias(static::ALIAS_USER_NAMES));

        return $names[random_int(0, count($names) - 1)];
    }

    /**
     * Получение идентификатора случайного города
     *
     * @return int Идентификатор города
     *
     * @throws Exception
     */
    public static function getRandomCityId(): int
    {
        $cityIds = City::find()
            ->select('id')
            ->column()
        ;

        return $cityIds[random_int(0, count($cityIds) - 1)];
    }

    /**
     * Получение идентификаторов случайных навыков
     *
     * @return int[] Список идентификаторов навыков
     *
     * @throws Exception
     */
    public static function getRandomSkillIds(): array
    {
        $randomSkillIds = [];
        $skillAmount = random_int(0, static::MAX_SKILL_AMOUNT);

        if ($skillAmount) {
            $skillIds = Skill::find()
                ->select('id')
                ->column()
            ;

            $columnAmount = count($skillIds);

            for ($counter = 0; $counter < $skillAmount; $counter++) {
                $skillId = $skillIds[random_int(0, $columnAmount - 1)];

                if (!isset($randomSkillIds[$skillId])) {
                    $randomSkillIds[$skillId] = $skillId;
                }
            }
        }

        return array_values($randomSkillIds);
    }
}
