<?php

use yii\db\Migration;

class m170707_085949_add_occupation_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'occupation', $this->string(125)->null()->after('status'));
        $this->addColumn('{{%user}}', 'occupation_other', $this->string(125)->null()->after('occupation'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'occupation');
        $this->dropColumn('{{%user}}', 'occupation_other');
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
