<?php

use yii\db\Migration;

class m170612_132330_add_contract_term_service_other_fee_other_to_rental_extension extends Migration
{
    public function up()
    {
        $this->addColumn('{{%rental_extension}}', 'service_fee_payment_term', $this->string(100)->null()->after('service_fee'));
        $this->addColumn('{{%rental_extension}}', 'other_fee_payment_term', $this->string(100)->null()->after('other_fee'));
        $this->addColumn('{{%rental_extension}}', 'other', $this->string(100)->null()->after('other_fee_payment_term'));
    }

    public function down()
    {
        $this->dropColumn('{{%rental_extension}}', 'service_fee_payment_term');
        $this->dropColumn('{{%rental_extension}}', 'other_fee_payment_term');
        $this->dropColumn('{{%rental_extension}}', 'other');
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
