<?php

use yii\db\Migration;

class m170622_091124_remove_contact_term_from_property extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%property}}', 'contact_term_for');
        $this->dropColumn('{{%property}}', 'other');
    }

    public function down()
    {
        echo "m170622_091124_remove_contact_term_from_property cannot be reverted.\n";

        return false;
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
