<?php

use yii\db\Migration;

class m161226_102651_create_email_template extends Migration
{
    public function up()
    {
        $this->createTable('mls_email_template', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(128)->notNull(),
            'subject' => $this->string()->null(),
            'content' => $this->text()->notNull(),
            'sms_text' => $this->string(512)->null(),
            'code' => $this->string(50)->null(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_email_template');
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
