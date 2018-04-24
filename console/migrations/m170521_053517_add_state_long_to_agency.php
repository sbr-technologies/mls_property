<?php

use yii\db\Migration;

class m170521_053517_add_state_long_to_agency extends Migration
{
    public function up()
    {
        $this->addColumn('{{%agency}}', 'state_long', $this->string(50)->notNull()->after('state'));
        $this->addColumn('{{%agency}}', 'agencyID', $this->string(100)->null()->after('id'));
    }

    public function down(){
        $this->dropColumn('{{%agency}}', 'state_long');
        $this->dropColumn('{{%agency}}', 'agencyID');
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
