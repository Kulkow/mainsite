<?php

use yii\db\Migration;

class m160213_083335_topic_add_category extends Migration
{
    public function up()
    {
        $this->addColumn('topic', 'category_id', $this->integer());
    }

    public function down()
    {
        echo "m160213_083335_topic_add_category cannot be reverted.\n";
        $this->dropColumn('topic', 'category_id');
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
