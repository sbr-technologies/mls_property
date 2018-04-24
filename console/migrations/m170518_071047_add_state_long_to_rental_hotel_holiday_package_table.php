<?php

use yii\db\Migration;

class m170518_071047_add_state_long_to_rental_hotel_holiday_package_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%rental}}', 'state_long', $this->string(50)->notNull()->after('state'));
        $this->addColumn('{{%hotel}}', 'state_long', $this->string(50)->notNull()->after('state'));
        $this->addColumn('{{%holiday_package}}', 'source_state_long', $this->string(50)->notNull()->after('source_state'));
        $this->addColumn('{{%holiday_package}}', 'destination_state_long', $this->string(50)->notNull()->after('destination_state'));
    }

    public function down()
    {
        $this->dropColumn('{{%rental}}', 'state_long');
        $this->dropColumn('{{%hotel}}', 'state_long');
        $this->dropColumn('{{%holiday_package}}', 'source_state_long');
        $this->dropColumn('{{%holiday_package}}', 'destination_state_long');
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
