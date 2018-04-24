<?php

use yii\db\Migration;

class m170816_070342_add_sold_details_to_property extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%property}}', 'sold_price', $this->bigInteger()->null()->after('price'));
        $this->addColumn('{{%property}}', 'sold_date', $this->date()->null()->after('sold_price'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%property}}', 'sold_price');
        $this->dropColumn('{{%property}}', 'sold_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170816_070342_add_sold_details_to_property cannot be reverted.\n";

        return false;
    }
    */
}
