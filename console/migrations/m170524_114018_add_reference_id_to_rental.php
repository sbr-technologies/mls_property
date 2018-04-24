<?php

use yii\db\Migration;

class m170524_114018_add_reference_id_to_rental extends Migration
{
    public function up()
    {
        $this->addColumn('{{%rental}}', 'reference_id', $this->string(100)->null()->after('id'));
    }

    public function down()
    {
        $this->dropColumn('{{%rental}}', 'reference_id');
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
