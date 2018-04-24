<?php

use yii\db\Migration;

class m170614_150012_remove_fields_from_property extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('fk-mls_property-property_type_id', '{{%property}}');
        $this->dropForeignKey('fk-mls_property-construction_status_id', '{{%property}}');
        $this->dropIndex('idx-mls_property-property_type_id', '{{%property}}');
        $this->dropIndex('idx-mls_property-construction_status_id', '{{%property}}');
        $this->dropColumn('{{%property}}', 'address1');
        $this->dropColumn('{{%property}}', 'address2');
        $this->dropColumn('{{%property}}', 'country');
        $this->dropColumn('{{%property}}', 'state');
        $this->dropColumn('{{%property}}', 'state_long');
        $this->dropColumn('{{%property}}', 'city');
        $this->dropColumn('{{%property}}', 'zip_code');
        $this->dropColumn('{{%property}}', 'land_mark');
        $this->dropColumn('{{%property}}', 'size');
        $this->dropColumn('{{%property}}', 'lot_area');
        $this->dropColumn('{{%property}}', 'no_of_balcony');
        $this->dropColumn('{{%property}}', 'lift');
        $this->dropColumn('{{%property}}', 'furnished');
        $this->dropColumn('{{%property}}', 'water_availability');
        $this->dropColumn('{{%property}}', 'electricity_type_ids');
        $this->dropColumn('{{%property}}', 'property_exterior_ids'); 
        $this->dropColumn('{{%property}}', 'watermark_image'); 
        $this->dropColumn('{{%property}}', 'sole_mandate'); 
        $this->dropColumn('{{%property}}', 'near_buy_location'); 
        $this->dropColumn('{{%property}}', 'property_video_link'); 
        $this->dropColumn('{{%property}}', 'featured'); 
    }

    public function down()
    {
        
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
