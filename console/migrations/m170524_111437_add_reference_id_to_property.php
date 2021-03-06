<?php

use yii\db\Migration;

class m170524_111437_add_reference_id_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'reference_id', $this->string(100)->null()->after('id'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'reference_id');
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
