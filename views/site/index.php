<?php

use app\assets\DataTableAsset;
use app\assets\IndexAsset;
use app\models\search\UserSearch;
use yii\web\View;

/**
 * @var View $this Объекта представления
 * @var UserSearch $userSearch Модель данных для поиска пользователей
 */

DataTableAsset::register($this);
IndexAsset::register($this);
?>
<table id="users" class="display">
    <thead>
        <tr>
            <th><?= $userSearch->getAttributeLabel('name'); ?></th>
            <th><?= $userSearch->getAttributeLabel('city'); ?></th>
            <th><?= $userSearch->getAttributeLabel('skills'); ?></th>
            <th></th>
        </tr>
    </thead>
</table>

<button id="add">Добавить пользователя</button>
