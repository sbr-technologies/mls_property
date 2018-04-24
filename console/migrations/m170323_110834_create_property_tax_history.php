<?php

use yii\db\Migration;

class m170323_110834_create_property_tax_history extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_tax_history', [
            'id' => $this->bigPrimaryKey(),
            'property_id'=> $this->bigInteger()->notNull(),
            'year' => $this->string(15)->notNull(),
            'taxes' => $this->decimal(7,2)->null(),
            'land' => $this->decimal(7,2)->null(),
            'addition' => $this->decimal(7,2)->null(),
            'total_assesment' => $this->decimal(7,2)->null(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_tax_history-property_id',
            'mls_property_tax_history',
            'property_id'
        );

        // add foreign key for table `mls_property_tax_history`
        $this->addForeignKey(
            'fk-mls_property_tax_history-property_id',
            'mls_property_tax_history',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_property_tax_history');
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
