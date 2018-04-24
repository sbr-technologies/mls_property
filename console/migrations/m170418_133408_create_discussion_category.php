<?php

use yii\db\Migration;

class m170418_133408_create_discussion_category extends Migration
{
    public function up()
    {
        $this->createTable('{{%discussion_category}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(255)->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%discussion_category}}');
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
