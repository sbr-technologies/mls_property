<?php

use yii\db\Migration;

class m161226_103911_create_newsletter_template extends Migration
{
    public function up()
    {
        $this->createTable('mls_newsletter_template', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(128)->notNull(),
            'subject' => $this->string()->null(),
            'content' => $this->text()->notNull(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->notNull(),
            'updated_by' => $this->bigInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_newsletter_template');
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
