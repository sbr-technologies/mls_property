<?php

use yii\db\Migration;

class m161226_103505_create_newsletter_email_list_subscribe extends Migration
{
    public function up()
    {
        $this->createTable('mls_newsletter_email_list_subscriber', [
            'id' => $this->bigPrimaryKey(),
            'subscriber_id' => $this->bigInteger()->notNull(),
            'list_id' => $this->bigInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `subscriber_id`
        $this->createIndex(
            'idx-mls_newsletter_email_list_subscriber-subscriber_id',
            'mls_newsletter_email_list_subscriber',
            'subscriber_id'
        );

        // add foreign key for table `mls_newsletter_email_subscriber`
        $this->addForeignKey(
            'fk-mls_newsletter_email_list_subscriber-subscriber_id',
            'mls_newsletter_email_list_subscriber',
            'subscriber_id',
            'mls_newsletter_email_subscriber',
            'id',
            'CASCADE'
        );
        
        // creates index for column `list_id`
        $this->createIndex(
            'idx-mls_newsletter_email_list_subscriber-list_id',
            'mls_newsletter_email_list_subscriber',
            'list_id'
        );

        // add foreign key for table `mls_newsletter_email_list`
        $this->addForeignKey(
            'fk-mls_newsletter_email_list_subscriber-list_id',
            'mls_newsletter_email_list_subscriber',
            'list_id',
            'mls_newsletter_email_list',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_newsletter_email_list_subscriber');
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
