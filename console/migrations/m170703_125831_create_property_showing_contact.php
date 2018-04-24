<?php

use yii\db\Migration;

class m170703_125831_create_property_showing_contact extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->dropColumn('{{%property}}', 'contact_person');
        $this->dropColumn('{{%property}}', 'location_key');
        $this->dropColumn('{{%property}}', 'showing_instruction');
        
        $this->createTable('{{%property_showing_contact}}', [
            'id'                    =>  $this->bigPrimaryKey(),
            'property_id'           =>  $this->bigInteger()->null(),
            'first_name'            =>  $this->string(75)->null(),
            'middle_name'           =>  $this->string(75)->null(),
            'last_name'             =>  $this->string(75)->null(),
            'email'                 =>  $this->string(125)->null(),
            'phone1'                =>  $this->string(35)->null(),
            'phone2'                =>  $this->string(35)->null(),
            'phone3'                =>  $this->string(35)->null(),
            'key_location'          =>  $this->text()->null(),
            'showing_instruction'   =>  $this->longText()->null(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_showing_contact-property_id',
            'mls_property_showing_contact',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_property_showing_contact-property_id',
            'mls_property_showing_contact',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_property_showing_contact');
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
