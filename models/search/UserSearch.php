<?php

namespace app\models\search;

use app\models\User;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;

/**
 * Модель данных для поиска пользователей
 *
 * @package app\models\search
 */
class UserSearch extends User
{
    /**
     * @var array Список доступных атрибутов сортировки
     */
    public const SORT_ATTRIBUTES = ['name', 'city', 'skills'];

    /**
     * @var int Размер страницы по умолчанию
     */
    public const PAGE_SIZE_DEFAULT = 10;

    /**
     * @var string Атрибут сортировки по умолчанию
     */
    public const SORT_ATTRIBUTE_DEFAULT = 'name';

    /**
     * @var string Текст поиска
     */
    public $searchText;

    /**
     * @var string Название города пользователя
     */
    public $city;

    /**
     * @var string Навыки пользователя
     */
    public $skills;

    /**
     * @var int Смещение поиска
     */
    public $offset;

    /**
     * @var int Количество получаемых записей
     */
    public $limit;

    /**
     * @var string Атрибут сортировки
     */
    public $sortAttribute;

    /**
     * @var int Код типа сортировки
     */
    public $sortType;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['searchText'], 'string', 'max' => 64],
            [['offset', 'limit'], 'integer'],
            [['sortAttribute'], 'in', 'range' => static::SORT_ATTRIBUTES],
            [['sortType'], 'in', 'range' => [SORT_DESC, SORT_ASC]],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'searchText' => 'Поиск',
            'city' => 'Город',
            'skills' => 'Навыки',
        ]);
    }

    /**
     * Получение провайдера данных для поиска пользователей
     *
     * @return ActiveDataProvider Провайдер данных
     */
    public function search(): ActiveDataProvider
    {
        $subQuery = static::find()
            ->joinWith(['city', 'skills'])
            ->select([
                'id' => '{{%user}}.id',
                'name' => '{{%user}}.name',
                'city' => '{{%city}}.name',
                'skills' => new Expression('GROUP_CONCAT({{%skill}}.name ORDER BY {{%skill}}.name SEPARATOR \', \')'),
            ])
            ->groupBy('{{%user}}.id')
        ;

        $query = (new Query())
            ->from(new Expression('(' . $subQuery->createCommand()->rawSql . ') user_info'))
            ->orderBy([
                $this->sortAttribute ?: static::SORT_ATTRIBUTE_DEFAULT => $this->sortType ?: SORT_ASC,
                'id' => SORT_ASC,
            ])
        ;

        if ($this->searchText) {
            $query->andWhere(['or',
                ['like', 'name', $this->searchText],
                ['like', 'city', $this->searchText],
                ['like', 'skills', $this->searchText],
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize = $this->limit ? (int) $this->limit : static::PAGE_SIZE_DEFAULT,
                'page' => $this->offset ? floor($this->offset / $pageSize) : 0,
            ],
            'sort' => false,
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Получение названия атрибута сортировки по его номеру
     *
     * @param string|null $attributeNumber Номер атрибута или <code>null</code>
     *
     * @return string|null Название атрибута или <code>null</code>
     */
    public static function getSortAttributeByNumber(?string $attributeNumber): ?string
    {
        return static::SORT_ATTRIBUTES[$attributeNumber] ?? null;
    }
}
