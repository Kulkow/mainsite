<?php

use yii\db\Schema;
use yii\db\Migration;

class m150811_193228_topic extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%topic}}', [
            'id' => Schema::TYPE_PK,
            'h1' => Schema::TYPE_STRING . '(255) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(255) NOT NULL UNIQUE',
            'title' => Schema::TYPE_STRING . '(90) NOT NULL',
            'keywords' => Schema::TYPE_STRING . '(255)',
            'description' => Schema::TYPE_STRING . '(255)',
            'announce' => Schema::TYPE_TEXT . '',
            'content' => Schema::TYPE_TEXT . '',
            'owner' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'editor' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'image' => Schema::TYPE_INTEGER . '(11) default NULL',
            'created' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'updated' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'active' => Schema::TYPE_SMALLINT .'(1) default 1',
            //'INDEX (owner)',
            'FOREIGN KEY (owner) REFERENCES "user"(id) ON DELETE CASCADE',
            'FOREIGN KEY (editor) REFERENCES "user"(id) ON DELETE CASCADE',
        ], $tableOptions);
        $this->createTable('{{%tag_topic}}', [
            'id' => Schema::TYPE_PK,
            'topic_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'tag_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            //'INDEX topic_ind (topic_id)',
            'FOREIGN KEY (topic_id) REFERENCES topic(id) ON DELETE CASCADE',
            //'INDEX tag_ind (tag_id)',
            'FOREIGN KEY (tag_id) REFERENCES tag(id) ON DELETE CASCADE'
        ], $tableOptions);
    }

    public function down()
    {
        echo "m150811_193228_topic cannot be reverted.\n";
        $this->dropTable('{{%topic}}');
        $this->dropTable('{{%tag_topic}}');
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
