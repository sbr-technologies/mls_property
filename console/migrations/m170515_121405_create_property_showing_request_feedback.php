<?php

use yii\db\Migration;

class m170515_121405_create_property_showing_request_feedback extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up(){
        $this->createTable('mls_property_showing_request_feedback', [
            'id' => $this->bigPrimaryKey(),
            'showing_request_id' => $this->bigInteger()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'requested_to'=>$this->bigInteger()->null(),
            'property_id' => $this->bigInteger()->null(),
            'reply'=>$this->longText()->notNull(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_property_showing_request_feedback-showing_request_id',
            'mls_property_showing_request_feedback',
            'showing_request_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_property_showing_request_feedback-showing_request_id',
            'mls_property_showing_request_feedback',
            'showing_request_id',
            'mls_property_showing_request',
            'id',
            'CASCADE'
        );
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_property_showing_request_feedback-user_id',
            'mls_property_showing_request_feedback',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_property_showing_request_feedback-user_id',
            'mls_property_showing_request_feedback',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_showing_request_feedback-property_id',
            'mls_property_showing_request_feedback',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_property_showing_request_feedback-property_id',
            'mls_property_showing_request_feedback',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down(){
        $this->dropTable('mls_property_showing_request_feedback');
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
