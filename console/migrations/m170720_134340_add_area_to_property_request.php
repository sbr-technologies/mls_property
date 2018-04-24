<?php

use yii\db\Migration;

class m170720_134340_add_area_to_property_request extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%property_request}}', 'area', $this->string(125)->null()->after('state'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%property_request}}', 'area');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170720_134340_add_area_to_property_request cannot be reverted.\n";

        return false;
    }
    */
}
