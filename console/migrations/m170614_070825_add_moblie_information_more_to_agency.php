<?php

use yii\db\Migration;

class m170614_070825_add_moblie_information_more_to_agency extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%agency}}', 'calling_code_mobile2');
        $this->dropColumn('{{%agency}}', 'calling_code_mobile3');
        $this->dropColumn('{{%agency}}', 'calling_code_fax');
        $this->dropColumn('{{%agency}}', 'fax');
        $this->addColumn('{{%agency}}', 'mobile4', $this->string(35)->null()->after('mobile3'));
        $this->addColumn('{{%agency}}', 'calling_code2', $this->string(35)->null()->after('mobile4'));
        $this->addColumn('{{%agency}}', 'office1', $this->string(35)->null()->after('calling_code2'));
        $this->addColumn('{{%agency}}', 'office2', $this->string(35)->null()->after('office1'));
        $this->addColumn('{{%agency}}', 'office3', $this->string(35)->null()->after('office2'));
        $this->addColumn('{{%agency}}', 'office4', $this->string(35)->null()->after('office3'));
        $this->addColumn('{{%agency}}', 'calling_code3', $this->string(35)->null()->after('office3'));
        $this->addColumn('{{%agency}}', 'fax1', $this->string(35)->null()->after('calling_code3'));
        $this->addColumn('{{%agency}}', 'fax2', $this->string(35)->null()->after('fax1'));
        $this->addColumn('{{%agency}}', 'fax3', $this->string(35)->null()->after('fax2'));
        $this->addColumn('{{%agency}}', 'fax4', $this->string(35)->null()->after('fax3'));
        $this->addColumn('{{%agency}}', 'calling_code4', $this->string(35)->null()->after('fax4'));
    }

    public function down()
    {
        $this->dropColumn('{{%agency}}', 'mobile4');
        $this->dropColumn('{{%agency}}', 'calling_code2');
        $this->dropColumn('{{%agency}}', 'office1');
        $this->dropColumn('{{%agency}}', 'office2');
        $this->dropColumn('{{%agency}}', 'office3');
        $this->dropColumn('{{%agency}}', 'office4');
        $this->dropColumn('{{%agency}}', 'calling_code3');
        $this->dropColumn('{{%agency}}', 'fax1');
        $this->dropColumn('{{%agency}}', 'fax2');
        $this->dropColumn('{{%agency}}', 'fax3');
        $this->dropColumn('{{%agency}}', 'fax4');
        $this->dropColumn('{{%agency}}', 'calling_code4');
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
