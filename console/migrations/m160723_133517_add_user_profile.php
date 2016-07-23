<?php

use yii\db\Schema;
use yii\db\Migration;

class m160723_133517_add_user_profile extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_profile}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'fio' => Schema::TYPE_STRING . '(255) NOT NULL',
            'profile' => Schema::TYPE_TEXT,
            'gender' => Schema::TYPE_INTEGER . "(1) NOT NULL default '1'",
        ], $tableOptions);
    }

    public function down()
    {
        echo "m160723_133517_add_user_profile cannot be reverted.\n";
        $this->dropTable('{{%user_profile}}');
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
