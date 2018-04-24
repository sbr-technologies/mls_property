<?php

use yii\db\Migration;

class m170609_091803_modify_on_rental_extension extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%rental_extension}}', 'service_fee_for');
        $this->dropColumn('{{%rental_extension}}', 'other_fee_for');
        $this->addColumn('{{%rental_extension}}', 'contact_term', $this->string(100)->null()->after('other_fee'));
        $this->addColumn('{{%rental_extension}}', 'contact_term_for', $this->string(100)->null()->after('contact_term'));

    }

    public function down()
    {
        $this->dropColumn('{{%rental_extension}}', 'contact_term');
        $this->dropColumn('{{%rental_extension}}', 'contact_term_for');
        $this->addColumn('{{%rental_extension}}', 'service_fee_for', $this->integer()->null()->after('service_fee'));
        $this->addColumn('{{%rental_extension}}', 'other_fee_for', $this->integer()->null()->after('other_fee'));
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
