<?php

use yii\db\Migration;

class m170522_092548_add_calling_code_telephone_to_agency extends Migration
{
    public function up()
    {
        $this->addColumn('{{%agency}}', 'calling_code_telephone', $this->string(100)->null()->after('fax'));
    }

    public function down()
    {
        $this->dropColumn('{{%agency}}', 'calling_code_telephone');
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
