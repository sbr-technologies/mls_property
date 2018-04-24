<?php

use yii\db\Migration;

class m170622_095707_add_location_key_to_property extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
 	$this->addColumn('{{%property}}', 'contact_person', $this->longText()->null()->after('contact_term'));
        $this->addColumn('{{%property}}', 'location_key', $this->longText()->null()->after('contact_person'));
    }

    public function down()
    {
       $this->dropColumn('{{%property}}', 'contact_person');
       $this->dropColumn('{{%property}}', 'location_key');
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
