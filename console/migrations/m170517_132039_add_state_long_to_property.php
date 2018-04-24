<?php

use yii\db\Migration;

class m170517_132039_add_state_long_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'state_long', $this->string(50)->notNull()->after('state'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'state_long');
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
