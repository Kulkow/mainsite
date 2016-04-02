<?php

use yii\db\Schema;
use yii\db\Migration;

class m160215_173434_create_projects extends Migration
{
    public function up()
    {
        $this->createTable('{{%projects}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'alias' => $this->string(255)->unique(),
            'title' => $this->string(70),
            'keywords' => $this->string(255),
            'description' => $this->string(255),
            'created' => $this->integer(11),
            'updated' => $this->integer(11),
            'owner' => $this->integer(11),
            'category_id' => $this->integer(11),
            'company_id' => $this->integer(11),
            'announce' => $this->text(),
            'content' => $this->text(),
            'preview' => $this->string(255),
            'active' => $this->boolean()->defaultValue(true),
            'FOREIGN KEY (owner) REFERENCES "user"(id) ON DELETE CASCADE',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%projects}}');
        return true;
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
