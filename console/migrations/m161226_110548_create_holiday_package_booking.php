<?php

use yii\db\Migration;

class m161226_110548_create_holiday_package_booking extends Migration
{
    public function up()
    {
        $this->createTable('mls_holiday_package_booking', [
            'id' => $this->bigPrimaryKey(),
            'booking_generated_id' => $this->string(50)->notNull(),
            'holiday_package_id' => $this->bigInteger()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'departure_date' => $this->integer()->notNull(),
            'departure_location' => $this->string(100)->null(),
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
        
        // creates index for column `holiday_package_id`
        $this->createIndex(
            'idx-mls_holiday_package_booking-holiday_package_id',
            'mls_holiday_package_booking',
            'holiday_package_id'
        );

        // add foreign key for table `mls_holiday_package`
        $this->addForeignKey(
            'fk-mls_holiday_package_booking-holiday_package_id',
            'mls_holiday_package_booking',
            'holiday_package_id',
            'mls_holiday_package',
            'id',
            'CASCADE'
        );
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_holiday_package_booking-user_id',
            'mls_holiday_package_booking',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_holiday_package_booking-user_id',
            'mls_holiday_package_booking',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_holiday_package_booking');
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
