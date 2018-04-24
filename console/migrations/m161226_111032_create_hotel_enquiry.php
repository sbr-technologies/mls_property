<?php

use yii\db\Migration;

class m161226_111032_create_hotel_enquiry extends Migration
{
    public function up()
    {
        $this->createTable('mls_hotel_enquiry', [
            'id' => $this->bigPrimaryKey(),
            'hotel_id' => $this->bigInteger()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull(),
            'enquiry_at' => $this->integer()->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
        
        // creates index for column `category_id`
        $this->createIndex(
            'idx-mls_hotel_enquiry-hotel_id',
            'mls_hotel_enquiry',
            'hotel_id'
        );

        // add foreign key for table `mls_hotel`
        $this->addForeignKey(
            'fk-mls_hotel_enquiry-hotel_id',
            'mls_hotel_enquiry',
            'hotel_id',
            'mls_hotel',
            'id',
            'CASCADE'
        );
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_hotel_enquiry-user_id',
            'mls_hotel_enquiry',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_hotel_enquiry-user_id',
            'mls_hotel_enquiry',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_hotel_enquiry');
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
