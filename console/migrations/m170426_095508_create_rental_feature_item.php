<?php

use yii\db\Migration;

class m170426_095508_create_rental_feature_item extends Migration
{
    public function up(){
        $this->createTable('mls_rental_feature_item', [
            'id' => $this->bigPrimaryKey(),
            'rental_feature_id' => $this->bigInteger()->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_rental_feature_item-property_id',
            'mls_rental_feature_item',
            'rental_feature_id'
        );

        // add foreign key for table `mls_rental_feature_item`
        $this->addForeignKey(
            'fk-mls_rental_feature_item-property_id',
            'mls_rental_feature_item',
            'rental_feature_id',
            'mls_rental_feature',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_rental_feature_item');
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
