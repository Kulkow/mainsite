<?php

use yii\db\Schema;
use yii\db\Migration;

class m150805_144756_role extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'role',  Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1');
    }

    public function down()
    {
        echo "m150805_144756_role cannot be reverted.\n";

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
