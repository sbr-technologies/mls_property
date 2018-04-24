<?php

use yii\db\Migration;

class m170522_092057_add_calling_code_fax_to_agency extends Migration
{
    public function up()
    {
        $this->addColumn('{{%agency}}', 'calling_code_fax', $this->string(100)->null()->after('mobile'));
    }

    public function down()
    {
        $this->dropColumn('{{%agency}}', 'calling_code_fax');
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
