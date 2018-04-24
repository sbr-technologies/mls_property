<?php

use yii\db\Migration;

class m170609_105404_add_market_status_on_rental_extension extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%rental_extension}}', 'rental_category');
        $this->addColumn('{{%rental_extension}}', 'market_status', $this->string(100)->null()->after('contact_term_for'));
    }

    public function down()
    {
        $this->dropColumn('{{%rental_extension}}', 'market_status');
        $this->addColumn('{{%rental_extension}}', 'rental_category', $this->string(100)->null()->after('homes'));
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
