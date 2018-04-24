<?php

use yii\db\Migration;

class m170612_111230_add_property_exterior_ids_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'property_exterior_ids', $this->string(100)->null()->after('user_id'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'property_exterior_ids');
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
