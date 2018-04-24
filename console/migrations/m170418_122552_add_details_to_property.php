<?php

use yii\db\Migration;

class m170418_122552_add_details_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'tax', $this->integer()->notNull()->defaultValue(0)->after('price'));
        $this->addColumn('{{%property}}', 'insurance', $this->integer()->notNull()->defaultValue(0)->after('tax'));
        $this->addColumn('{{%property}}', 'hoa_fees', $this->integer()->notNull()->defaultValue(0)->after('insurance'));
        $this->addColumn('{{%property}}', 'mortgage_insurance', $this->integer()->notNull()->defaultValue(0)->after('hoa_fees'));
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
