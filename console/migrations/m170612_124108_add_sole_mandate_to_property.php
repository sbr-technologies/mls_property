<?php

use yii\db\Migration;

class m170612_124108_add_sole_mandate_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'sole_mandate', $this->string(15)->null()->after('total_reviews'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'sole_mandate');
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
