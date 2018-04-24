<?php

use yii\db\Migration;

class m170621_145148_add_property_contact_for_to_property_contact extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%property}}', 'property_contact_for');
        $this->addColumn('{{%property_contact}}', 'property_contact_for', $this->string(75)->null()->after('property_id'));
        $this->addColumn('{{%photo_gallery}}', 'sort_order', $this->integer()->null()->after('description'));
        $this->addColumn('{{%attachment}}', 'sort_order', $this->integer()->null()->after('description'));
    }

    public function down()
    {
        $this->dropColumn('{{%property_contact}}', 'property_contact_for');
        $this->dropColumn('{{%photo_gallery}}', 'sort_order');
        $this->dropColumn('{{%attachment}}', 'sort_order');
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
