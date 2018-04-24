<?php

use yii\db\Migration;

class m170516_102218_add_schedule_o_property_request extends Migration
{
    public function up(){
        $this->addColumn('{{%property_request}}', 'schedule', $this->date()->notNull()->after('locality'));
    }

    public function down()
    {
        echo "m170516_102218_add_schedule_o_property_request cannot be reverted.\n";

        return false;
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
