<?php

use yii\db\Migration;

class m170711_115524_add_schedule_end_to_property_showing_request extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property_showing_request}}', 'schedule_end', $this->integer()->null()->after('schedule'));
    }

    public function down()
    {
        $this->dropColumn('{{%property_showing_request}}', 'schedule_end');
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
