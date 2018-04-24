<?php

use yii\db\Migration;

class m170629_062547_add_slug_to_agency extends Migration
{
    public function up()
    {
        $this->addColumn('{{%agency}}', 'slug', $this->string(255)->notNull()->after('name'));
        $this->renameColumn('{{%agency}}', 'city', 'town');
        $this->renameColumn('{{%agency}}', 'address1', 'street_address');
        $this->dropColumn('{{%agency}}', 'state_long');
        $this->dropColumn('{{%agency}}', 'address2');
        $this->addColumn('{{%agency}}', 'area', $this->string(75)->null()->after('town'));
        $this->addColumn('{{%agency}}', 'street_number', $this->string(75)->null()->after('street_address'));
        $this->addColumn('{{%agency}}', 'sub_area', $this->string(255)->null()->after('area'));
        $this->addColumn('{{%agency}}', 'local_govt_area', $this->string(255)->null()->after('zip_code'));
        $this->addColumn('{{%agency}}', 'urban_town_area', $this->string(255)->null()->after('local_govt_area'));
        $this->addColumn('{{%agency}}', 'district', $this->string(75)->null()->after('urban_town_area'));
    }

    public function down()
    {
        $this->dropColumn('{{%agency}}', 'slug');
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
