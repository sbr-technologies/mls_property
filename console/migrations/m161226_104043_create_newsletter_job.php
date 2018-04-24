<?php

use yii\db\Migration;

class m161226_104043_create_newsletter_job extends Migration
{
    public function up()
    {
        $this->createTable('mls_newsletter_job', [
            'id' => $this->bigPrimaryKey(),
            'template_id' => $this->bigInteger()->notNull(),
            'list_id' => $this->bigInteger()->null(),
            'subscriber_id' => $this->bigInteger()->null(),
            'name' => $this->string(128)->notNull(),
            'attempts' => $this->integer()->notNull(),
            'run_at' => $this->integer()->null(),
            'last_error' => $this->text()->null(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->notNull(),
            'updated_by' => $this->bigInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `template_id`
        $this->createIndex(
            'idx-mls_newsletter_job-template_id',
            'mls_newsletter_job',
            'template_id'
        );

        // add foreign key for table `mls_newsletter_template`
        $this->addForeignKey(
            'fk-mls_newsletter_job-template_id',
            'mls_newsletter_job',
            'template_id',
            'mls_newsletter_template',
            'id',
            'CASCADE'
        );
        
        // creates index for column `list_id`
        $this->createIndex(
            'idx-mls_newsletter_job-list_id',
            'mls_newsletter_job',
            'list_id'
        );

        // add foreign key for table `mls_newsletter_email_list`
        $this->addForeignKey(
            'fk-mls_newsletter_job-list_id',
            'mls_newsletter_job',
            'list_id',
            'mls_newsletter_email_list',
            'id',
            'CASCADE'
        );
        
        // creates index for column `subscriber_id`
        $this->createIndex(
            'idx-mls_newsletter_job-subscriber_id',
            'mls_newsletter_job',
            'subscriber_id'
        );

        // add foreign key for table `mls_newsletter_email_subscriber`
        $this->addForeignKey(
            'fk-mls_newsletter_job-subscriber_id',
            'mls_newsletter_job',
            'subscriber_id',
            'mls_newsletter_email_subscriber',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
       $this->dropTable('mls_newsletter_job');
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
