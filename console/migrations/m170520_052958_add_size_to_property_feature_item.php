<?php

use yii\db\Migration;

class m170520_052958_add_size_to_property_feature_item extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property_feature_item}}', 'size', $this->string(50)->notNull()->after('name'));
    }

    public function down()
    {
        $this->dropColumn('{{%property_feature_item}}', 'size');
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
