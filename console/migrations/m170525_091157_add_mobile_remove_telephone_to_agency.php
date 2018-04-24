<?php

use yii\db\Migration;

class m170525_091157_add_mobile_remove_telephone_to_agency extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%agency}}', 'calling_code_telephone');
        $this->dropColumn('{{%agency}}', 'telephone');
        $this->addColumn('{{%agency}}', 'calling_code_mobile2', $this->string(100)->null()->after('mobile'));
        $this->addColumn('{{%agency}}', 'mobile2', $this->string(35)->null()->after('calling_code_mobile2'));
        $this->addColumn('{{%agency}}', 'calling_code_mobile3', $this->string(100)->null()->after('mobile2'));
        $this->addColumn('{{%agency}}', 'mobile3', $this->string(35)->null()->after('calling_code_mobile3'));
    }

    public function down()
    {
        $this->dropColumn('{{%agency}}', 'calling_code_mobile2');
        $this->dropColumn('{{%agency}}', 'mobile2');
        $this->dropColumn('{{%agency}}', 'calling_code_mobile3');
        $this->dropColumn('{{%agency}}', 'mobile3');
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
