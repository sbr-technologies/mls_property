<?php

use yii\db\Migration;

class m170519_123008_add_worked_with_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'worked_with', $this->string(75)->notNull()->after('last_activity_at'));
        $this->addColumn('{{%user}}', 'state_long', $this->string(75)->notNull()->after('state'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'worked_with');
        $this->dropColumn('{{%user}}', 'state_long');
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
