<?php

use yii\db\Migration;

class m170620_122010_add_agency_id_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'agency_id', $this->bigInteger()->null()->after('user_id'));
        $this->addColumn('{{%property}}', 'property_contact_for', $this->string(75)->null()->after('avg_rating'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'agency_id');
        //$this->dropColumn('{{%property}}', 'property_contact_for');
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
