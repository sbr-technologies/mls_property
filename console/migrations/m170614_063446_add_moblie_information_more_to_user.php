<?php

use yii\db\Migration;

class m170614_063446_add_moblie_information_more_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'calling_code4', $this->string(35)->null()->after('fax3'));
        $this->addColumn('{{%user}}', 'mobile4', $this->string(35)->null()->after('mobile3'));
        $this->addColumn('{{%user}}', 'office4', $this->string(35)->null()->after('office3'));
        $this->addColumn('{{%user}}', 'fax4', $this->string(35)->null()->after('fax3'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'calling_code4');
        $this->dropColumn('{{%user}}', 'mobile4');
        $this->dropColumn('{{%user}}', 'office4');
        $this->dropColumn('{{%user}}', 'fax4');
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
