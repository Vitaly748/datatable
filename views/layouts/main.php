<?php

use yii\bootstrap4\Html;
use yii\web\View;

/**
 * @var View $this Объекта представления
 * @var $content string Основное содержимое страницы
 */

$title = Yii::$app->name;
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= $title; ?></title>
        <link rel="shortcut icon" href="/favicon.ico">
        <?= Html::csrfMetaTags(); ?>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>

        <header>
            <a href="/"><?= $title; ?></a>
        </header>

        <?= $content; ?>

        <?php $this->endBody(); ?>
    </body>
</html>
<?php
$this->endPage();
