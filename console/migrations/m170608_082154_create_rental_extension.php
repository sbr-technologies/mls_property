<?php

use yii\db\Migration;

class m170608_082154_create_rental_extension extends Migration
{
    public function up()
    {
        $this->createTable('{{%rental_extension}}', [
            'id'                =>  $this->bigPrimaryKey(),
            'property_id'       =>  $this->bigInteger()->null(),
            'studio'            =>  $this->integer()->null()->defaultValue(0),
            'pet_friendly'      =>  $this->integer()->null()->defaultValue(0),
            'in_unit_laundry'   =>  $this->integer()->null()->defaultValue(0),
            'pools'             =>  $this->integer()->null()->defaultValue(0),
            'homes'             =>  $this->integer()->null()->defaultValue(0),
            'rental_category'   =>  $this->string(75)->null(),
            'price_for'         =>  $this->string(35)->null(),
            'service_fee'       =>  $this->integer()->null(),
            'service_fee_for'   =>  $this->string(35)->null(),
            'other_fee'         =>  $this->integer()->null(),
            'other_fee_for'     =>  $this->string(35)->null(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_rental_extension-property_id',
            'mls_rental_extension',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_rental_extension-property_id',
            'mls_rental_extension',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%rental_extension}}');
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
