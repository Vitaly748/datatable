<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Миграция по инициализации табличной схемы
 */
class m200412_034657_init extends Migration
{
    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'DEFAULT CHARSET = utf8');

        $this->createTable('{{%skill}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'DEFAULT CHARSET = utf8');

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'city_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'DEFAULT CHARSET = utf8');

        $this->createTable('{{%pv_user_skill}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'skill_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'DEFAULT CHARSET = utf8');

        $this->createIndex(
            'ux-city-name',
            '{{%city}}',
            'name',
            true
        );

        $this->createIndex(
            'ux-skill-name',
            '{{%skill}}',
            'name',
            true
        );

        $this->createIndex(
            'idx-user-city_id',
            '{{%user}}',
            'city_id'
        );

        $this->addForeignKey(
            'fk-user-city_id',
            '{{%user}}',
            'city_id',
            '{{%city}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-pv_user_skill-user_id',
            '{{%pv_user_skill}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-pv_user_skill-user_id',
            '{{%pv_user_skill}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-pv_user_skill-skill_id',
            '{{%pv_user_skill}}',
            'skill_id'
        );

        $this->addForeignKey(
            'fk-pv_user_skill-skill_id',
            '{{%pv_user_skill}}',
            'skill_id',
            '{{%skill}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritDoc
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-pv_user_skill-skill_id',
            '{{%pv_user_skill}}'
        );

        $this->dropIndex(
            'idx-pv_user_skill-skill_id',
            '{{%pv_user_skill}}'
        );

        $this->dropForeignKey(
            'fk-pv_user_skill-user_id',
            '{{%pv_user_skill}}'
        );

        $this->dropIndex(
            'idx-pv_user_skill-user_id',
            '{{%pv_user_skill}}'
        );

        $this->dropForeignKey(
            'fk-user-city_id',
            '{{%user}}'
        );

        $this->dropIndex(
            'idx-user-city_id',
            '{{%user}}'
        );

        $this->dropIndex(
            'ux-skill-name',
            '{{%skill}}'
        );

        $this->dropIndex(
            'ux-city-name',
            '{{%city}}'
        );

        $this->dropTable('{{%pv_user_skill}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%skill}}');
        $this->dropTable('{{%city}}');
    }
}
