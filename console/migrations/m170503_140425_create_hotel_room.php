<?php

use yii\db\Migration;

class m170503_140425_create_hotel_room extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_hotel_room', [
            'id' => $this->bigPrimaryKey(),
            'hotel_id' => $this->bigInteger()->notNull(),
            'room_type_id' => $this->bigInteger()->notNull(),
            'name' => $this->string(125)->notNull(),
            'floor_name' => $this->string(125)->notNull(),
            'inclusion' =>  $this->longText()->null(),
            'amenities' =>  $this->longText()->null(),
            'ac'    =>  $this->smallInteger()->notNull(),
            'status' => $this->string(15)->notNull(),
            
        ]);
        // creates index for column `hotel_id`
        $this->createIndex(
            'idx-mls_hotel_room-hotel_id',
            'mls_hotel_room',
            'hotel_id'
        );

        // add foreign key for table `mls_hotel`
        $this->addForeignKey(
            'fk-mls_hotel_room-hotel_id',
            'mls_hotel_room',
            'hotel_id',
            'mls_hotel',
            'id',
            'CASCADE'
        );
        
        // creates index for column `room_type_id`
        $this->createIndex(
            'idx-mls_hotel_room-room_type_id',
            'mls_hotel_room',
            'room_type_id'
        );

        // add foreign key for table `mls_room_type`
        $this->addForeignKey(
            'fk-mls_hotel_room-room_type_id',
            'mls_hotel_room',
            'room_type_id',
            'mls_room_type',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_hotel_room');
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
