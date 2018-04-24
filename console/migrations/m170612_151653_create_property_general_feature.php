<?php

use yii\db\Migration;

class m170612_151653_create_property_general_feature extends Migration
{
    public function up()
    {
        $this->createTable('{{%property_general_feature}}', [
            'id'                => $this->bigPrimaryKey(),
            'property_id'       =>  $this->bigInteger()->null(),
            'type'              => $this->string(35)->notNull(),
            'name'              => $this->string()->notNull(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_general_feature-property_id',
            'mls_property_general_feature',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_property_general_feature-property_id',
            'mls_property_general_feature',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
         $this->dropTable('{{%property_general_feature}}');
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
