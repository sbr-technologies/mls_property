<?php

use yii\db\Migration;

class m170323_110815_create_property_price_history extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_price_history', [
            'id' => $this->bigPrimaryKey(),
            'property_id'=> $this->bigInteger()->notNull(),
            'date' => $this->date()->notNull(),
            'price' => $this->decimal(7,2)->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_price_history-property_id',
            'mls_property_price_history',
            'property_id'
        );

        // add foreign key for table `mls_property_price_history`
        $this->addForeignKey(
            'fk-mls_property_price_history-property_id',
            'mls_property_price_history',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_property_price_history');
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
