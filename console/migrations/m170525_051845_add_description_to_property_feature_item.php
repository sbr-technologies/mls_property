<?php

use yii\db\Migration;

class m170525_051845_add_description_to_property_feature_item extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->addColumn('{{%property_feature_item}}', 'description', $this->longText()->null()->after('size'));
    }

    public function down()
    {
        $this->dropColumn('{{%property_feature_item}}', 'description');
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
