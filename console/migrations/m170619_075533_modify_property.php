<?php

use yii\db\Migration;

class m170619_075533_modify_property extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%property}}', 'market_status');
        $this->addColumn('{{%property}}', 'market_status', $this->string(50)->null()->after('featured'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'market_status');
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
