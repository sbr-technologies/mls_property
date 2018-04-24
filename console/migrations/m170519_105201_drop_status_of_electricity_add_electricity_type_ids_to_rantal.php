<?php

use yii\db\Migration;

class m170519_105201_drop_status_of_electricity_add_electricity_type_ids_to_rantal extends Migration
{
    public function up(){
        $this->dropColumn('{{%rental}}', 'status_of_electricity');
        $this->addColumn('{{%rental}}', 'electricity_type_ids', $this->string()->notNull()->after('water_availability'));
    }

    public function down()
    {
        $this->dropColumn('{{%rental}}', 'electricity_type_ids');
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
