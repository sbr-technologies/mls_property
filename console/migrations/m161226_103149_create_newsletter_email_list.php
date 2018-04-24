<?php

use yii\db\Migration;

class m161226_103149_create_newsletter_email_list extends Migration
{
    public function up()
    {
        $this->createTable('mls_newsletter_email_list', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->null(),
            'last_mail_sent_at' => $this->integer()->null(),
            'total_mail_sent' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_newsletter_email_list');
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
