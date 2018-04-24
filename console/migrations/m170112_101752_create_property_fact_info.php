<?php

use yii\db\Migration;

class m170112_101752_create_property_fact_info extends Migration
{
    public function up()
    {
        $this->createTable('{{%property_fact_info}}', [
            'id' => $this->bigPrimaryKey(),
            'property_id' => $this->bigInteger()->notNull(),
            'fact_master_id' => $this->bigInteger()->notNull(),
            'title' => $this->string()->notNull(),
            'description'=>$this->text()->null(),
            'status' => $this->string(15)->notNull(),
        ]);
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-property_fact_info-property_id',
            '{{%property_fact_info}}',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-property_fact_info-property_id',
            '{{%property_fact_info}}',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
        // creates index for column `fact_master_id`
        $this->createIndex(
            'idx-property_fact_info-fact_master_id',
            '{{%property_fact_info}}',
            'fact_master_id'
        );

        // add foreign key for table `fact_master`
        $this->addForeignKey(
            'fk-property_fact_info-fact_master_id',
            '{{%property_fact_info}}',
            'fact_master_id',
            '{{%fact_master}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%property_fact_info}}');
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
