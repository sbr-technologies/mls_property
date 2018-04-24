<?php

use yii\db\Migration;

class m161226_110051_create_hotel_booking extends Migration
{
    public function up()
    {
        $this->createTable('mls_hotel_booking', [
            'id' => $this->bigPrimaryKey(),
            'booking_generated_id' => $this->string(50)->notNull(),
            'hotel_id' => $this->bigInteger()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'room' => $this->string(128)->notNull(),
            'check_in_date' => $this->integer()->notNull(),
            'check_out_date' => $this->integer()->notNull(),
            'amount' => $this->decimal(7,2)->notNull(),
            'payment_mode' => $this->string(20)->notNull(),
            'card_last_4_digit' => $this->integer(4)->null(),
            'no_of_adult' => $this->integer(4)->notNull(),
            'no_of_children' => $this->integer(4)->null()->defaultValue(0),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `hotel_id`
        $this->createIndex(
            'idx-mls_hotel_booking-hotel_id',
            'mls_hotel_booking',
            'hotel_id'
        );

        // add foreign key for table `mls_hotel`
        $this->addForeignKey(
            'fk-mls_hotel_booking-hotel_id',
            'mls_hotel_booking',
            'hotel_id',
            'mls_hotel',
            'id',
            'CASCADE'
        );
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_hotel_booking-user_id',
            'mls_hotel_booking',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_hotel_booking-user_id',
            'mls_hotel_booking',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_hotel_booking');
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
