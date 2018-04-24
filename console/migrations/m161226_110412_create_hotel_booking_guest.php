<?php

use yii\db\Migration;

class m161226_110412_create_hotel_booking_guest extends Migration
{
    public function up()
    {
        $this->createTable('mls_hotel_booking_guest', [
            'id' => $this->bigPrimaryKey(),
            'booking_id' => $this->bigInteger()->notNull(),
            'first_name' => $this->string(128)->notNull(),
            'last_name' => $this->string(128)->notNull(),
            'middle_name' => $this->string(128)->null(),
            'gender'=> $this->smallInteger()->notNull(),
            'age' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_hotel_booking_guest');
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
