<?php

use yii\db\Migration;

class m170619_084516_modify_property_category extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property_category}}', 'sort_order', $this->integer()->null()->after('description'));
    }

    public function down()
    {
        $this->dropColumn('{{%property_category}}', 'sort_order');
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
