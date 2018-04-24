<?php

use yii\db\Migration;

class m170607_063035_add_refference_id_to_property_request extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%property_request}}', 'budget');
        $this->addColumn('{{%property_request}}', 'budget_from', $this->integer()->notNull()->after('property_type_id'));
        $this->addColumn('{{%property_request}}', 'budget_to', $this->integer()->null()->after('budget_from'));
        $this->addColumn('{{%property_request}}', 'referenceId', $this->string(100)->null()->after('id'));
    }

    public function down()
    {
        $this->addColumn('{{%property_request}}', 'budget', $this->integer()->notNull()->after('property_type_id'));
        $this->dropColumn('{{%property_request}}', 'budget_from');
        $this->dropColumn('{{%property_request}}', 'budget_to');
        $this->dropColumn('{{%property_request}}', 'budget_to');
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
