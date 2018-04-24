<?php

use yii\db\Migration;

class m170713_123821_change_adress_field_on_hotel extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%hotel}}', 'city', 'town');
        $this->renameColumn('{{%hotel}}', 'address1', 'street_address');
        $this->dropColumn('{{%hotel}}', 'state_long');
        $this->dropColumn('{{%hotel}}', 'address2');
        $this->addColumn('{{%hotel}}', 'area', $this->string(75)->null()->after('town'));
        $this->addColumn('{{%hotel}}', 'street_number', $this->string(75)->null()->after('street_address'));
        $this->addColumn('{{%hotel}}', 'sub_area', $this->string(255)->null()->after('area'));
        $this->addColumn('{{%hotel}}', 'local_govt_area', $this->string(255)->null()->after('zip_code'));
        $this->addColumn('{{%hotel}}', 'urban_town_area', $this->string(255)->null()->after('local_govt_area'));
        $this->addColumn('{{%hotel}}', 'district', $this->string(75)->null()->after('urban_town_area'));
        $this->addColumn('{{%hotel}}', 'appartment_unit', $this->string(75)->null()->after('district'));
    }

    public function down()
    {
        $this->renameColumn('{{%hotel}}', 'town', 'city');
        $this->renameColumn('{{%hotel}}', 'street_address', 'address1');
        $this->addColumn('{{%hotel}}', 'state_long', $this->string(75)->null()->after('state'));
        $this->addColumn('{{%hotel}}', 'address2', $this->string(128)->null()->after('address1'));
        $this->dropColumn('{{%hotel}}', 'area');
        $this->dropColumn('{{%hotel}}', 'street_number');
        $this->dropColumn('{{%hotel}}', 'sub_area');
        $this->dropColumn('{{%hotel}}', 'local_govt_area');
        $this->dropColumn('{{%hotel}}', 'urban_town_area');
        $this->dropColumn('{{%hotel}}', 'district');
        $this->dropColumn('{{%hotel}}', 'appartment_unit');
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
