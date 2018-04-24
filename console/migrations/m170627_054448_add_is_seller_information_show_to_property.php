<?php

use yii\db\Migration;

class m170627_054448_add_is_seller_information_show_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'is_seller_information_show', $this->integer()->defaultValue(0)->after('status'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'is_seller_information_show');
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
