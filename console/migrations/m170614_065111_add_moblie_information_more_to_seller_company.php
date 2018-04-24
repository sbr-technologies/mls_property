<?php

use yii\db\Migration;

class m170614_065111_add_moblie_information_more_to_seller_company extends Migration
{
    public function up()
    {
        $this->addColumn('{{%seller_company}}', 'calling_code4', $this->string(35)->null()->after('fax3'));
        $this->addColumn('{{%seller_company}}', 'mobile4', $this->string(35)->null()->after('mobile3'));
        $this->addColumn('{{%seller_company}}', 'office4', $this->string(35)->null()->after('office3'));
        $this->addColumn('{{%seller_company}}', 'fax4', $this->string(35)->null()->after('fax3'));
    }

    public function down()
    {
        $this->dropColumn('{{%seller_company}}', 'calling_code4');
        $this->dropColumn('{{%seller_company}}', 'mobile4');
        $this->dropColumn('{{%seller_company}}', 'office4');
        $this->dropColumn('{{%seller_company}}', 'fax4');
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
