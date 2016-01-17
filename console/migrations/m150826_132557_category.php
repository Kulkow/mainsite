<?php

use yii\db\Schema;
use yii\db\Migration;

class m150826_132557_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%category}}', [
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
            'root' => Schema::TYPE_INTEGER . '(11) default NULL',
            'lft' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'lvl' => Schema::TYPE_SMALLINT .'(5) NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'icon' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'icon_type' => Schema::TYPE_SMALLINT .'(1) NOT NULL DEFAULT 1',
            'active' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT TRUE',
            'selected' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT FALSE',
            'disabled' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT FALSE',
            'readonly' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT FALSE',
            'visible' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT TRUE',
            'collapsed' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT FALSE',
            'movable_u' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT TRUE',
            'movable_d' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT TRUE',
            'movable_l' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT TRUE',
            'movable_r' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT TRUE',
            'removable' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT TRUE',
            'removable_all' => Schema::TYPE_BOOLEAN .'(1) NOT NULL DEFAULT FALSE',
            //'INDEX (owner)',
            //'KEY tbl_tree_NK1 (root)',
            //'KEY tbl_tree_NK2 (lft)',
            //'KEY tbl_tree_NK3 (rgt)',
            //'KEY tbl_tree_NK4 (lvl)',
            //'KEY tbl_tree_NK5 (active)'
        ], $tableOptions);
    }

    public function down()
    {
        echo "m150826_132557_category cannot be reverted.\n";

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
