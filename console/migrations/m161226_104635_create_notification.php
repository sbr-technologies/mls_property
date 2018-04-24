<?php

use yii\db\Migration;

class m161226_104635_create_notification extends Migration
{
    public function up()
    {
        $this->createTable('mls_notification', [
            'id' => $this->bigPrimaryKey(),
            'shown_to' => $this->bigInteger()->notNull(),
            'sent_by' => $this->bigInteger()->notNull(),
            'read' => $this->smallInteger(2)->notNull(),
            'type' => $this->string(34)->notNull(),
            'data' => $this->string(512)->null(),
            'target_path' => $this->string()->null(),
            'icon_class' => $this->string(128)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `shown_to`
        $this->createIndex(
            'idx-mls_notification-shown_to',
            'mls_notification',
            'shown_to'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_notification-shown_to',
            'mls_notification',
            'shown_to',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `sent_by`
        $this->createIndex(
            'idx-mls_notification-sent_by',
            'mls_notification',
            'sent_by'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_notification-sent_by',
            'mls_notification',
            'sent_by',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_notification');
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
