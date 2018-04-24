<?php

use yii\db\Migration;

class m170615_105214_add_market_status_to_property extends Migration
{
    public function up()
    {
       // $this->dropColumn('{{%property}}', 'mortgage_insurance');
        $this->addColumn('{{%property}}', 'market_status', $this->integer()->defaultValue(0)->after('featured'));
        $this->addColumn('{{%property}}', 'price_for', $this->string(35)->after('price'));
        $this->addColumn('{{%property}}', 'service_fee', $this->integer()->after('price_for'));
        $this->addColumn('{{%property}}', 'service_fee_payment_term', $this->string(35)->after('service_fee'));
        $this->addColumn('{{%property}}', 'other_fee', $this->integer()->after('service_fee_payment_term'));
        $this->addColumn('{{%property}}', 'other_fee_payment_term', $this->string(35)->after('other_fee'));
        $this->addColumn('{{%property}}', 'other', $this->string(100)->after('other_fee_payment_term'));
        $this->addColumn('{{%property}}', 'contact_term', $this->string(100)->after('other'));
        $this->addColumn('{{%property}}', 'contact_term_for', $this->string(100)->after('contact_term'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'market_status');
        $this->dropColumn('{{%property}}', 'price_for');
        $this->dropColumn('{{%property}}', 'service_fee');
        $this->dropColumn('{{%property}}', 'service_fee_payment_term');
        $this->dropColumn('{{%property}}', 'other_fee');
        $this->dropColumn('{{%property}}', 'other_fee_payment_term');
        $this->dropColumn('{{%property}}', 'other');
        $this->dropColumn('{{%property}}', 'contact_term');
        $this->dropColumn('{{%property}}', 'contact_term_for');
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
