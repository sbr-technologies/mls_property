<?php

use yii\db\Migration;

class m170522_082020_add_agentID_to_usser extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'agentID', $this->string(100)->null()->after('id'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'agentID');
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
