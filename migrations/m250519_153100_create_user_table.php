<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m250519_153100_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->createTable('user', [
        'id' => $this->primaryKey(),
        'first_name' => $this->string()->notNull(),
        'last_name' => $this->string()->notNull(),
        'username' => $this->string()->notNull()->unique(),
        'email' => $this->string()->notNull()->unique(),
        'phone' => $this->string()->notNull(),
        'password_hash' => $this->string()->notNull(),
        'auth_key' => $this->string(32),
        'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
    ]);        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
