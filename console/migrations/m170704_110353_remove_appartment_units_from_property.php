<?php

use yii\db\Migration;

class m170704_110353_remove_appartment_units_from_property extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%property}}', 'appartment_units');
    }

    public function down()
    {
        $this->addColumn('{{%property}}', 'appartment_units', $this->string(75)->null()->after('appartment_unit'));
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
