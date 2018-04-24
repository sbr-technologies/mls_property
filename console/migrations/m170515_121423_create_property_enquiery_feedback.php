<?php

use yii\db\Migration;

class m170515_121423_create_property_enquiery_feedback extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up(){
        $this->createTable('{{%property_enquiery_feedback}}', [
            'id' => $this->bigPrimaryKey(),
            'proerty_enquiery_id' => $this->bigInteger()->notNull(),
            'property_id'=> $this->bigInteger()->notNull(),
            'replay' => $this->longText()->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
        // creates index for column `post_id`
        $this->createIndex(
            'idx-property_enquiery_feedback-proerty_enquiery_id',
            '{{%property_enquiery_feedback}}',
            'proerty_enquiery_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-property_enquiery_feedback-proerty_enquiery_id',
            '{{%property_enquiery_feedback}}',
            'proerty_enquiery_id',
            '{{%property_enquiery}}',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_enquiery_feedback-property_id',
            'mls_property_enquiery_feedback',
            'property_id'
        );

        // add foreign key for table `mls_property_enquiery_feedback`
        $this->addForeignKey(
            'fk-mls_property_enquiery_feedback-property_id',
            'mls_property_enquiery_feedback',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down(){
        $this->dropTable('mls_property_enquiery_feedback');
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
