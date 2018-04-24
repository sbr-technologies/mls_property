<?php

use yii\db\Migration;

class m161230_072402_create_property_request extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_request', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'property_id' => $this->bigInteger()->notNull(),
            'status' => $this->string()->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_property_request-user_id',
            'mls_property_request',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_property_request-user_id',
            'mls_property_request',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_request-property_id',
            'mls_property_request',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_property_request-property_id',
            'mls_property_request',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_property_request');
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
