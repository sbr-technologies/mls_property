<?php

use yii\db\Migration;

class m170614_061906_add_moblie_information_to_seller_company extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%seller_company}}', 'calling_code_mobile2');
        $this->dropColumn('{{%seller_company}}', 'calling_code_mobile3');
        $this->dropColumn('{{%seller_company}}', 'calling_code_fax');
        $this->dropColumn('{{%seller_company}}', 'fax');
        $this->addColumn('{{%seller_company}}', 'calling_code2', $this->string(35)->null()->after('mobile3'));
        $this->addColumn('{{%seller_company}}', 'office1', $this->string(35)->null()->after('calling_code2'));
        $this->addColumn('{{%seller_company}}', 'office2', $this->string(35)->null()->after('office1'));
        $this->addColumn('{{%seller_company}}', 'office3', $this->string(35)->null()->after('office2'));
        $this->addColumn('{{%seller_company}}', 'calling_code3', $this->string(35)->null()->after('office3'));
        $this->addColumn('{{%seller_company}}', 'fax1', $this->string(35)->null()->after('calling_code3'));
        $this->addColumn('{{%seller_company}}', 'fax2', $this->string(35)->null()->after('fax1'));
        $this->addColumn('{{%seller_company}}', 'fax3', $this->string(35)->null()->after('fax2'));
        
    }

    public function down()
    {
        $this->dropColumn('{{%seller_company}}', 'calling_code2');
        $this->dropColumn('{{%seller_company}}', 'office1');
        $this->dropColumn('{{%seller_company}}', 'office2');
        $this->dropColumn('{{%seller_company}}', 'office3');
        $this->dropColumn('{{%seller_company}}', 'calling_code3');
        $this->dropColumn('{{%seller_company}}', 'fax1');
        $this->dropColumn('{{%seller_company}}', 'fax2');
        $this->dropColumn('{{%seller_company}}', 'fax3');
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
