<?php

use yii\db\Migration;

class m170525_093946_add_mobile2_mobile3_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'mobile2', $this->string(35)->null()->after('phone_number'));
        $this->addColumn('{{%user}}', 'mobile3', $this->string(35)->null()->after('mobile2'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'mobile2');
        $this->dropColumn('{{%user}}', 'mobile3');
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
