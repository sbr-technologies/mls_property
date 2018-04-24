<?php

use yii\db\Migration;

class m170728_065110_add_flag_to_property_contact extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%property_contact}}', 'flag', $this->integer()->defaultValue(0)->after('value'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%property_contact}}', 'flag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170728_065110_add_flag_to_property_contact cannot be reverted.\n";

        return false;
    }
    */
}
