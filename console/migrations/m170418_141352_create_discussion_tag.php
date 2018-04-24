<?php

use yii\db\Migration;

class m170418_141352_create_discussion_tag extends Migration
{
    public function up()
    {
        $this->createTable('{{%discussion_tag}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(255)->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%discussion_tag}}');
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
