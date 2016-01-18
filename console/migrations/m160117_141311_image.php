<?php

use yii\db\Schema;
use yii\db\Migration;

class m160117_141311_image extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%image}}', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_STRING . '(255) NOT NULL',
            'realname' => Schema::TYPE_STRING . '(255) NOT NULL',
            'path' => Schema::TYPE_STRING . '(255) NOT NULL',
            'alt' => Schema::TYPE_STRING . '(255)',
            'hide' => Schema::TYPE_BOOLEAN ,
            'timestamp' => Schema::TYPE_TIMESTAMP ,
            'model' => Schema::TYPE_STRING . '(255)',
            'model_id' => Schema::TYPE_INTEGER .' default NULL',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m160117_141311_image cannot be reverted.\n";
        $this->dropTable('{{%image}}');
        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
