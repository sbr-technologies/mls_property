<?php

use yii\db\Migration;

class m170606_060143_remove_property_id_add_model_model_id_to_property_enquiery extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk-mls_property_enquiery-property_id', '{{%property_enquiery}}');
        $this->dropColumn('{{%property_enquiery}}', 'property_id');
        $this->addColumn('{{%property_enquiery}}', 'model_id', $this->bigInteger()->notNull()->after('id'));
        $this->addColumn('{{%property_enquiery}}', 'model', $this->string(100)->notNull()->after('model_id'));
    }

    public function down()
    {
        $this->dropColumn('{{%property_enquiery}}', 'model_id');
        $this->dropColumn('{{%property_enquiery}}', 'model');
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
