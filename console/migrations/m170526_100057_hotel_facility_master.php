<?php

use yii\db\Migration;

class m170526_100057_hotel_facility_master extends Migration
{
    public function safeUp(){
        $this->createTable('{{%hotel_facility_master}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(15)->null(),
        ]);
        
        $this->batchInsert('{{%hotel_facility_master}}', ['name', 'status'], [
            ['Private Bathroom', 'active'],
            ['Parking', 'active'],
            ['Pool', 'active'],
            ['Restaurant', 'active'],
            ['Bar', 'active'],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%hotel_facility_master}}');
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
