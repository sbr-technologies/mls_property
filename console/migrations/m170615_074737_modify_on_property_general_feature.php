<?php

use yii\db\Migration;

class m170615_074737_modify_on_property_general_feature extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%property_general_feature}}', 'type');
        $this->dropColumn('{{%property_general_feature}}', 'name');
        $this->addColumn('{{%property_general_feature}}', 'general_feature_master_id', $this->bigInteger()->after('property_id'));
        
        $this->createIndex(
            'idx-mls_property_general_feature-general_feature_master_id',
            'mls_property_general_feature',
            'general_feature_master_id'
        );

        // add foreign key for table `general_feature_master`
        $this->addForeignKey(
            'fk-mls_property_general_feature-general_feature_master_id',
            'mls_property_general_feature',
            'general_feature_master_id',
            'mls_general_feature_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        
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
