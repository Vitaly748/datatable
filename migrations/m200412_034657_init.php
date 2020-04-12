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
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], 'DEFAULT CHARSET = utf8');

        $this->createTable('{{%skill}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], 'DEFAULT CHARSET = utf8');

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'city_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], 'DEFAULT CHARSET = utf8');

        $this->createTable('{{%user_skill}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'skill_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], 'DEFAULT CHARSET = utf8');

        $this->createIndex(
            'idx-user-city_id',
            'user',
            'city_id'
        );

        $this->addForeignKey(
            'fk-user-city_id',
            'user',
            'city_id',
            'city',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_skill-user_id',
            'user_skill',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_skill-user_id',
            'user_skill',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_skill-skill_id',
            'user_skill',
            'skill_id'
        );

        $this->addForeignKey(
            'fk-user_skill-skill_id',
            'user_skill',
            'skill_id',
            'skill',
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
            'fk-user_skill-skill_id',
            'user_skill'
        );

        $this->dropIndex(
            'idx-user_skill-skill_id',
            'user_skill'
        );

        $this->dropForeignKey(
            'fk-user_skill-user_id',
            'user_skill'
        );

        $this->dropIndex(
            'idx-user_skill-user_id',
            'user_skill'
        );

        $this->dropForeignKey(
            'fk-user-city_id',
            'user'
        );

        $this->dropIndex(
            'idx-user-city_id',
            'user'
        );

        $this->dropTable('{{%user_skill}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%skill}}');
        $this->dropTable('{{%city}}');
    }
}
