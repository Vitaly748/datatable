<?php

use yii\db\Migration;
use yii\db\Exception as DbException;

/**
 * Миграцию по добавлению записей в таблицы "city" и "skill"
 */
class m200413_130415_add_cities_and_skills extends Migration
{
    /**
     * @var array Список городов
     */
    public const CITIES = ['Москва', 'Пермь', 'Санкт-Петербург', 'Казань', 'Ташкент', 'Ижевск', 'Тагил', 'Амстердам', 'Екатеринбарг',
        'Сызрань', 'Минск', 'Владимир', 'Самара', 'Днепропетровск', 'Киров', 'Глазов', 'Петропавловск', 'Тольятти', 'Барнаул', 'Томск'];

    /**
     * @var array Список навыков
     */
    public const SKILLS = ['Строительство домов', 'Кулинария', 'Программирование', 'Каллиграфия', 'Уборка', 'Сельское хозяйство',
        'Чтение', 'Письмо', 'Живопись', 'Фехтование', 'Вождение автомобиля', 'Управление вертолётом', 'Лазанье по канату', 'Коммуникация',
        'Гребля', 'Майнинг', 'Дизайн', 'Красноречие', 'Дрессура', 'Акробатика'];

    /**
     * @inheritDoc
     *
     * @throws DbException
     * @throws Exception
     */
    public function safeUp()
    {
        $rows = array_map(function($value) {
            return [$value];
        }, static::CITIES);

        $insert = $this->db->createCommand()
            ->batchInsert('{{%city}}', ['name'], $rows)
            ->execute()
        ;

        if (!$insert) {
            throw new Exception('Ошибка вставки записей в таблицу городов');
        }

        $rows = array_map(function($value) {
            return [$value];
        }, static::SKILLS);

        $insert = $this->db->createCommand()
            ->batchInsert('{{%skill}}', ['name'], $rows)
            ->execute()
        ;

        if (!$insert) {
            throw new Exception('Ошибка вставки записей в таблицу навыков');
        }
    }

    /**
     * @inheritDoc
     */
    public function safeDown()
    {
        $this->delete('{{%city}}', ['name' => static::CITIES]);
        $this->delete('{{%skill}}', ['name' => static::SKILLS]);
    }
}
