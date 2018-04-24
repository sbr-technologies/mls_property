<?php

use yii\db\Migration;

class m170607_141251_add_calling_code_and_mobile_to_seller_company extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%seller_company}}', 'telephone');
        $this->addColumn('{{%seller_company}}', 'calling_code', $this->string(100)->null()->after('email'));
        $this->addColumn('{{%seller_company}}', 'calling_code_mobile2', $this->string(100)->null()->after('mobile'));
        $this->addColumn('{{%seller_company}}', 'mobile2', $this->string(35)->null()->after('calling_code_mobile2'));
        $this->addColumn('{{%seller_company}}', 'calling_code_mobile3', $this->string(100)->null()->after('mobile2'));
        $this->addColumn('{{%seller_company}}', 'mobile3', $this->string(35)->null()->after('calling_code_mobile3'));
        $this->addColumn('{{%seller_company}}', 'calling_code_fax', $this->string(35)->null()->after('mobile3'));
        

    }

    public function down()
    {
        $this->addColumn('{{%seller_company}}', 'telephone', $this->string(100)->null()->after('mobile'));
        $this->dropColumn('{{%seller_company}}', 'calling_code');
        $this->dropColumn('{{%seller_company}}', 'calling_code_mobile2');
        $this->dropColumn('{{%seller_company}}', 'mobile2');
        $this->dropColumn('{{%seller_company}}', 'calling_code_mobile3');
        $this->dropColumn('{{%seller_company}}', 'mobile3');
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
