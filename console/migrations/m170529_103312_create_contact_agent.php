<?php

use yii\db\Migration;

class m170529_103312_create_contact_agent extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_contact_agent', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->null(),
            'property_id' => $this->bigInteger()->null(),
            'name'=>$this->string(125)->notNull(),
            'email'=>$this->string(75)->notNull(),
            'phone'=>$this->string(35)->notNull(),
            'message'=>$this->longText()->null(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_contact_agent-user_id',
            'mls_contact_agent',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_contact_agent-user_id',
            'mls_contact_agent',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_contact_agent-property_id',
            'mls_contact_agent',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_contact_agent-property_id',
            'mls_contact_agent',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_contact_agent');
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
