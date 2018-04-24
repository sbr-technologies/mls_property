<?php

use yii\db\Migration;

class m170621_141922_add_appartment_units_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'appartment_units', $this->string(75)->null()->after('appartment_unit'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'appartment_units');
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
