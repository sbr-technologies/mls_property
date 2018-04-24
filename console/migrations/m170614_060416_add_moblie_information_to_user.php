<?php

use yii\db\Migration;

class m170614_060416_add_moblie_information_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'calling_code2', $this->string(35)->null()->after('mobile3'));
        $this->addColumn('{{%user}}', 'office1', $this->string(35)->null()->after('calling_code2'));
        $this->addColumn('{{%user}}', 'office2', $this->string(35)->null()->after('office1'));
        $this->addColumn('{{%user}}', 'office3', $this->string(35)->null()->after('office2'));
        $this->addColumn('{{%user}}', 'calling_code3', $this->string(35)->null()->after('office3'));
        $this->addColumn('{{%user}}', 'fax1', $this->string(35)->null()->after('calling_code3'));
        $this->addColumn('{{%user}}', 'fax2', $this->string(35)->null()->after('fax1'));
        $this->addColumn('{{%user}}', 'fax3', $this->string(35)->null()->after('fax2'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'calling_code2');
        $this->dropColumn('{{%user}}', 'office1');
        $this->dropColumn('{{%user}}', 'office2');
        $this->dropColumn('{{%user}}', 'office3');
        $this->dropColumn('{{%user}}', 'calling_code3');
        $this->dropColumn('{{%user}}', 'fax1');
        $this->dropColumn('{{%user}}', 'fax2');
        $this->dropColumn('{{%user}}', 'fax3');
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
