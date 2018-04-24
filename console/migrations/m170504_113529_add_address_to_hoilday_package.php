<?php

use yii\db\Migration;

class m170504_113529_add_address_to_hoilday_package extends Migration
{
    public function up()
    {
        $this->addColumn('{{%holiday_package}}', 'source_address', $this->string(125)->notNull()->after('total_reviews'));
        $this->addColumn('{{%holiday_package}}', 'source_city', $this->string(75)->notNull()->after('source_address'));
        $this->addColumn('{{%holiday_package}}', 'source_state', $this->string(75)->notNull()->after('source_city'));
        $this->addColumn('{{%holiday_package}}', 'source_country', $this->string(75)->notNull()->after('source_state'));
        $this->addColumn('{{%holiday_package}}', 'destination_address', $this->string(125)->notNull()->after('source_country'));
        $this->addColumn('{{%holiday_package}}', 'destination_city', $this->string(75)->notNull()->after('destination_address'));
        $this->addColumn('{{%holiday_package}}', 'destination_state', $this->string(75)->notNull()->after('destination_city'));
        $this->addColumn('{{%holiday_package}}', 'destination_country', $this->string(75)->notNull()->after('destination_state'));
    }

    public function down()
    {
        $this->dropColumn('{{%holiday_package}}', 'source_address');
        $this->dropColumn('{{%holiday_package}}', 'source_city');
        $this->dropColumn('{{%holiday_package}}', 'source_state');
        $this->dropColumn('{{%holiday_package}}', 'source_country');
        $this->dropColumn('{{%holiday_package}}', 'destination_address');
        $this->dropColumn('{{%holiday_package}}', 'destination_city');
        $this->dropColumn('{{%holiday_package}}', 'destination_state');
        $this->dropColumn('{{%holiday_package}}', 'destination_country');
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
