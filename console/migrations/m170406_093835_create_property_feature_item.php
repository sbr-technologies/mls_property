<?php

use yii\db\Migration;

class m170406_093835_create_property_feature_item extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_feature_item', [
            'id' => $this->bigPrimaryKey(),
            'property_feature_id' => $this->bigInteger()->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_feature_item-property_id',
            'mls_property_feature_item',
            'property_feature_id'
        );

        // add foreign key for table `mls_property_feature_item`
        $this->addForeignKey(
            'fk-mls_property_feature_item-property_id',
            'mls_property_feature_item',
            'property_feature_id',
            'mls_property_feature',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_property_feature_item');
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
