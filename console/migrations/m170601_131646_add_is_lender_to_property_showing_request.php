<?php

use yii\db\Migration;

class m170601_131646_add_is_lender_to_property_showing_request extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property_showing_request}}', 'is_lender', $this->integer()->null()->after('locality'));
    }

    public function down()
    {
        $this->dropColumn('{{%property_showing_request}}', 'is_lender');
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
