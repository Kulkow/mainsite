<?php

use yii\db\Schema;
use yii\db\Migration;

class m150810_060123_tag extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%tag}}', [
            'id' => Schema::TYPE_PK,
            'tag' => Schema::TYPE_STRING . '(255) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(255) NOT NULL UNIQUE',
            'count' => Schema::TYPE_INTEGER . ' default NULL',
            'topics' => Schema::TYPE_INTEGER . ' default NULL',
            'shares' => Schema::TYPE_INTEGER. ' default NULL',
            'labels' => Schema::TYPE_INTEGER. ' default NULL',
            'created' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated' => Schema::TYPE_INTEGER . ' NOT NULL',
            'active' => Schema::TYPE_SMALLINT .'(1) default 1',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m150810_060123_tag cannot be reverted.\n";
        $this->dropTable('{{%tag}}');
        //return false;
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
