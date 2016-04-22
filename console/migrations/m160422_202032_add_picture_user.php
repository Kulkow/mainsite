<?php

use yii\db\Migration;

class m160422_202032_add_picture_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'preview', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('user', 'preview');
    }
}
