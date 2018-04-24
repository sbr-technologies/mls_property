<?php

use yii\db\Migration;

class m170707_102502_add_list_expired_date_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'listed_date', $this->date()->null()->after('status'));
        $this->addColumn('{{%property}}', 'expired_date', $this->date()->null()->after('listed_date'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'listed_date');
        $this->dropColumn('{{%property}}', 'expired_date');
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
