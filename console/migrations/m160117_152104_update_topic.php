<?php

use yii\db\Schema;
use yii\db\Migration;

class m160117_152104_update_topic extends Migration
{
    public function up()
    {
        $this->addColumn('topic', 'preview', Schema::TYPE_STRING . '(255)');
    }

    public function down()
    {
        $this->removeColumn('topic', 'preview');
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
