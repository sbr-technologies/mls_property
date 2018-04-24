<?php

use yii\db\Migration;

class m170615_062600_add_new_fields_to_property extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%property}}', 'property_type_id', 'string');
        $this->alterColumn('{{%property}}', 'construction_status_id', 'string');
        $this->addColumn('{{%property}}', 'country', $this->string(75)->null()->after('description'));
        $this->addColumn('{{%property}}', 'state', $this->string(75)->null()->after('country'));
        $this->addColumn('{{%property}}', 'town', $this->string(75)->null()->after('state'));
        $this->addColumn('{{%property}}', 'area', $this->string(75)->null()->after('town'));
        $this->addColumn('{{%property}}', 'street_address', $this->string(255)->null()->after('area'));
        $this->addColumn('{{%property}}', 'street_number', $this->string(75)->null()->after('street_address'));
        $this->addColumn('{{%property}}', 'appartment_unit', $this->string(75)->null()->after('street_number'));
        $this->addColumn('{{%property}}', 'sub_area', $this->string(255)->null()->after('appartment_unit'));
        $this->addColumn('{{%property}}', 'zip_code', $this->integer()->null()->after('sub_area'));
        $this->addColumn('{{%property}}', 'local_govt_area', $this->string(255)->null()->after('zip_code'));
        $this->addColumn('{{%property}}', 'urban_town_area', $this->string(255)->null()->after('local_govt_area'));
        $this->addColumn('{{%property}}', 'district', $this->string(75)->null()->after('urban_town_area'));
        $this->addColumn('{{%property}}', 'lot_size', $this->integer()->null()->after('district'));
        $this->addColumn('{{%property}}', 'building_size', $this->integer()->null()->after('lot_size'));
        $this->addColumn('{{%property}}', 'house_size', $this->integer()->null()->after('building_size'));
        $this->addColumn('{{%property}}', 'no_of_toilet', $this->integer()->null()->after('no_of_garage'));
        $this->addColumn('{{%property}}', 'no_of_boys_quater', $this->integer()->null()->after('no_of_toilet'));
        $this->addColumn('{{%property}}', 'year_built', $this->integer()->null()->after('no_of_boys_quater'));
        $this->addColumn('{{%property}}', 'sole_mandate', $this->integer()->defaultValue(0)->after('year_built'));
        $this->addColumn('{{%property}}', 'preimum_lisitng', $this->integer()->defaultValue(0)->after('sole_mandate'));
        $this->addColumn('{{%property}}', 'virtual_link', $this->string(125)->after('preimum_lisitng'));
        $this->addColumn('{{%property}}', 'featured', $this->integer()->defaultValue(0)->after('virtual_link'));
        
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'country');
        $this->dropColumn('{{%property}}', 'state');
        $this->dropColumn('{{%property}}', 'town');
        $this->dropColumn('{{%property}}', 'area');
        $this->dropColumn('{{%property}}', 'street_address');
        $this->dropColumn('{{%property}}', 'street_number');
        $this->dropColumn('{{%property}}', 'appartment_unit');
        $this->dropColumn('{{%property}}', 'sub_area');
        $this->dropColumn('{{%property}}', 'zip_code');
        $this->dropColumn('{{%property}}', 'local_govt_area');
        $this->dropColumn('{{%property}}', 'urban_town_area');
        $this->dropColumn('{{%property}}', 'district');
        $this->dropColumn('{{%property}}', 'lot_size');
        $this->dropColumn('{{%property}}', 'building_size');
        $this->dropColumn('{{%property}}', 'house_size');
        $this->dropColumn('{{%property}}', 'no_of_toilet');
        $this->dropColumn('{{%property}}', 'no_of_boys_quater');
        $this->dropColumn('{{%property}}', 'year_built');
        $this->dropColumn('{{%property}}', 'sole_mandate');
        $this->dropColumn('{{%property}}', 'preimum_lisitng');
        $this->dropColumn('{{%property}}', 'virtual_link');
        $this->dropColumn('{{%property}}', 'featured');
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
