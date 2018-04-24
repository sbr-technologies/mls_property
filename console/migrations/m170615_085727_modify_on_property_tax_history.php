<?php

use yii\db\Migration;

class m170615_085727_modify_on_property_tax_history extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%property_tax_history}}', 'land');
        $this->dropColumn('{{%property_tax_history}}', 'addition');
        $this->dropColumn('{{%property_tax_history}}', 'total_assesment');
    }

    public function down()
    {
        
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
