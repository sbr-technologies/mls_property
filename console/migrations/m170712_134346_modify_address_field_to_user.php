<?php

use yii\db\Migration;

class m170712_134346_modify_address_field_to_user extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%user}}', 'city', 'town');
        $this->renameColumn('{{%user}}', 'address1', 'street_address');
        $this->dropColumn('{{%user}}', 'state_long');
        $this->dropColumn('{{%user}}', 'address2');
        $this->addColumn('{{%user}}', 'area', $this->string(75)->null()->after('town'));
        $this->addColumn('{{%user}}', 'street_number', $this->string(75)->null()->after('street_address'));
        $this->addColumn('{{%user}}', 'sub_area', $this->string(255)->null()->after('area'));
        $this->addColumn('{{%user}}', 'local_govt_area', $this->string(255)->null()->after('zip_code'));
        $this->addColumn('{{%user}}', 'urban_town_area', $this->string(255)->null()->after('local_govt_area'));
        $this->addColumn('{{%user}}', 'district', $this->string(75)->null()->after('urban_town_area'));
    }

    public function down()
    {
        $this->renameColumn('{{%user}}', 'town', 'city');
        $this->renameColumn('{{%user}}', 'street_address', 'address1');
        $this->addColumn('{{%user}}', 'state_long', $this->string(75)->null()->after('state'));
        $this->addColumn('{{%user}}', 'address2', $this->string(128)->null()->after('address1'));
        $this->dropColumn('{{%user}}', 'area');
        $this->dropColumn('{{%user}}', 'street_number');
        $this->dropColumn('{{%user}}', 'sub_area');
        $this->dropColumn('{{%user}}', 'local_govt_area');
        $this->dropColumn('{{%user}}', 'urban_town_area');
        $this->dropColumn('{{%user}}', 'district');
        
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
