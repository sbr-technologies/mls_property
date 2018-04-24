<?php

use yii\db\Migration;

class m170522_090156_add_calling_code_to_agency extends Migration
{
    public function up()
    {
 	$this->addColumn('{{%agency}}', 'calling_code', $this->string(100)->null()->after('email'));
    }

    public function down()
    {
        $this->dropColumn('{{%agency}}', 'calling_code');
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
