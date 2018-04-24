<?php

use yii\db\Migration;

class m170327_092920_create_property_enquiery extends Migration
{
    public function up()
    {
        $this->createTable('{{%property_enquiery}}', [
            'id' => $this->bigPrimaryKey(),
            'property_id'=> $this->bigInteger()->notNull(),
            'name' => $this->string(150)->notNull(),
            'email' => $this->string(75)->notNull(),
            'phone' => $this->string(15)->null(),
            'subject' => $this->string()->null(),
            'message' => $this->text()->null(),
            'assign_to' => $this->bigInteger()->null(),
            'status' => $this->string(15)->notNull(),
        ]);
        // creates index for column `post_id`
        $this->createIndex(
            'idx-property_enquiery-assign_to',
            '{{%property_enquiery}}',
            'assign_to'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-property_enquiery-assign_to',
            '{{%property_enquiery}}',
            'assign_to',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_enquiery-property_id',
            'mls_property_enquiery',
            'property_id'
        );

        // add foreign key for table `mls_property_enquiery`
        $this->addForeignKey(
            'fk-mls_property_enquiery-property_id',
            'mls_property_enquiery',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
        
    }

    public function down()
    {
        $this->dropTable('mls_property_enquiery');
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
