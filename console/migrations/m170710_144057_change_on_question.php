<?php

use yii\db\Migration;

class m170710_144057_change_on_question extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%question}}', 'title');
        $this->addColumn('{{%question}}', 'name', $this->string(125)->null()->after('user_id'));
        $this->addColumn('{{%question}}', 'email', $this->string(125)->null()->after('name'));
        $this->addColumn('{{%question}}', 'mobile', $this->string(25)->null()->after('email'));
    }

    public function down()
    {
        $this->dropColumn('{{%question}}', 'name');
        $this->dropColumn('{{%question}}', 'email');
        $this->dropColumn('{{%question}}', 'mobile');
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
