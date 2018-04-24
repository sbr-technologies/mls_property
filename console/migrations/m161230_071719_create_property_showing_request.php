<?php

use yii\db\Migration;

class m161230_071719_create_property_showing_request extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_showing_request', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->null(),
            'property_id' => $this->bigInteger()->null(),
            'schedule'=>$this->integer()->null(),
            'note'=>$this->text()->null(),
            'reply'=>$this->text()->null(),
            'name'=>$this->string(125)->notNull(),
            'email'=>$this->string(75)->notNull(),
            'phone'=>$this->string(35)->notNull(),
            'requested_by'=>$this->string(35)->null(),
            'looking_to'=>$this->string(35)->null(),
            'type'=>$this->string(75)->null(),
            'no_bedroom'=>$this->string(25)->null(),
            'budget'=>$this->string(15)->null(),
            'state'=>$this->string(25)->null(),
            'locality'=>$this->string(35)->null(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_property_showing_request-user_id',
            'mls_property_showing_request',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_property_showing_request-user_id',
            'mls_property_showing_request',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_showing_request-property_id',
            'mls_property_showing_request',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_property_showing_request-property_id',
            'mls_property_showing_request',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_property_showing_request');
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
