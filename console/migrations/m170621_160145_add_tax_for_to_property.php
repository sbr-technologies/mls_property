<?php

use yii\db\Migration;

class m170621_160145_add_tax_for_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'tax_for', $this->string(50)->null()->after('tax'));
        $this->addColumn('{{%property}}', 'insurance_for', $this->string(50)->null()->after('insurance'));
        $this->addColumn('{{%property}}', 'hoa_for', $this->string(50)->null()->after('hoa_fees'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'tax_for');
        $this->dropColumn('{{%property}}', 'insurance_for');
        $this->dropColumn('{{%property}}', 'hoa_for');
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
