<?php

use yii\db\Migration;

class m170426_095438_create_rental_feature extends Migration
{
    public function up(){
        $this->createTable('mls_rental_feature', [
            'id' => $this->bigPrimaryKey(),
            'rental_id' => $this->bigInteger()->notNull(),
            'feature_master_id' => $this->bigInteger()->notNull(),
        ]);
        // creates index for column `rental_id`
        $this->createIndex(
            'idx-mls_rental_feature-rental_id',
            'mls_rental_feature',
            'rental_id'
        );

        // add foreign key for table `mls_rental_feature`
        $this->addForeignKey(
            'fk-mls_rental_feature-rental_id',
            'mls_rental_feature',
            'rental_id',
            'mls_property',
            'id',
            'CASCADE'
        );
        
        // creates index for column `feature_master_id`
        $this->createIndex(
            'idx-mls_rental_feature-feature_master_id',
            'mls_rental_feature',
            'feature_master_id'
        );

        // add foreign key for table `mls_rental_feature`
        $this->addForeignKey(
            'fk-mls_rental_feature-feature_master_id',
            'mls_rental_feature',
            'feature_master_id',
            'mls_rental_feature_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_rental_feature');
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
