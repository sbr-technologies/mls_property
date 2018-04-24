<?php

use yii\db\Migration;

class m170615_094919_create_property_contact extends Migration
{
    public function up()
    {
        $this->createTable('{{%property_contact}}', [
            'id'                =>  $this->bigPrimaryKey(),
            'property_id'       =>  $this->bigInteger()->notNull(),
            'type'              =>  $this->string(75)->notNull(),
            'value'             =>  $this->string(175)->notNull(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_contact-property_id',
            'mls_property_contact',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_property_contact-property_id',
            'mls_property_contact',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%property_contact}}');
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
