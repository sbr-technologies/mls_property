<?php

use yii\db\Migration;

class m170530_091829_add_state_lat_lng_to_seller_company extends Migration
{
    public function up()
    {
        $this->addColumn('{{%seller_company}}', 'state_long', $this->string(70)->null()->after('state'));
        $this->addColumn('{{%seller_company}}', 'lat', $this->double(7)->null()->after('city'));
        $this->addColumn('{{%seller_company}}', 'lng', $this->double(7)->null()->after('lat'));
    }

    public function down()
    {
        $this->dropColumn('{{%seller_company}}', 'state_long');
        $this->dropColumn('{{%seller_company}}', 'lat');
        $this->dropColumn('{{%seller_company}}', 'lng');
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
