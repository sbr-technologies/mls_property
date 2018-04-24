<?php

use yii\db\Migration;

class m170509_132847_add_asky_by_to_question extends Migration
{
    public function up()
    {
        $this->addColumn('{{%question}}', 'ask_by', $this->bigInteger()->notNull()->after('description'));
    }

    public function down()
    {
        $this->dropColumn('{{%question}}', 'ask_by');
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
