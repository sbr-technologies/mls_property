<?php

use yii\db\Migration;

class m170616_093356_add_showing_instruction_to_property extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->addColumn('{{%property}}', 'showing_instruction', $this->longText()->null()->after('contact_term_for'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'showing_instruction');
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
