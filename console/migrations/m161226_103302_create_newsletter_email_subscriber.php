<?php

use yii\db\Migration;

class m161226_103302_create_newsletter_email_subscriber extends Migration
{
    public function up()
    {
        $this->createTable('mls_newsletter_email_subscriber', [
            'id' => $this->bigPrimaryKey(),
            'salutation' => $this->string(20)->null(),
            'first_name' => $this->string(128)->null(),
            'middle_name' => $this->string(128)->null(),
            'last_name' => $this->string(128)->null(),
            'email' => $this->string(150)->notNull(),
            'auth_key' => $this->string(128)->null(),
            'total_mail_sent' => $this->integer()->notNull()->defaultValue(0),
            'last_mail_sent_at' => $this->integer()->null(),
            'status' => $this->string(15)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_newsletter_email_subscriber');
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
