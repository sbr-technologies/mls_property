<?php

use yii\db\Migration;

class m170406_060615_create_property_feature extends Migration
{
    public function up(){
        $this->createTable('mls_property_feature', [
            'id' => $this->bigPrimaryKey(),
            'property_id' => $this->bigInteger()->notNull(),
            'feature_master_id' => $this->bigInteger()->notNull(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_feature-property_id',
            'mls_property_feature',
            'property_id'
        );

        // add foreign key for table `mls_property_feature`
        $this->addForeignKey(
            'fk-mls_property_feature-property_id',
            'mls_property_feature',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
        
        // creates index for column `feature_master_id`
        $this->createIndex(
            'idx-mls_property_feature-feature_master_id',
            'mls_property_feature',
            'feature_master_id'
        );

        // add foreign key for table `mls_property_feature`
        $this->addForeignKey(
            'fk-mls_property_feature-feature_master_id',
            'mls_property_feature',
            'feature_master_id',
            'mls_property_feature_master',
            'id',
            'CASCADE'
        );
    }

    public function down(){
        $this->dropTable('mls_property_feature');
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
