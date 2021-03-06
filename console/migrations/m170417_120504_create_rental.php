<?php

use yii\db\Migration;

class m170417_120504_create_rental extends Migration
{
    public function up()
    {
        $this->createTable('{{%rental}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id'=>$this->bigInteger()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'country' => $this->string()->notNull(),
            'state' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'address1' => $this->string()->notNull(),
            'address2' => $this->string()->null(),
            'lat' => $this->double(7)->notNull(),
            'lng' => $this->double(7)->notNull(),
            'zip_code' => $this->string(15)->notNull(),
            'land_mark' => $this->string()->null(),
            'near_buy_location' => $this->string()->null(),
            'metric_type_id' => $this->bigInteger()->notNull(),
            'size_range' => $this->string(125)->notNull(),
            'lot_area_range' => $this->string(125)->notNull(),
            'room_range'=>$this->string(125)->notNull(),
            'balcony_range'=>$this->string(125)->null(),
            'bathroom_range'=>$this->string(125)->null(),
            'lift'=>$this->integer()->notNull(),
            'studio'=>$this->integer()->notNull()->defaultValue(0),
            'pet_friendly'=>$this->integer()->notNull()->defaultValue(0),
            'in_unit_laundry'=>$this->integer()->notNull()->defaultValue(0),
            'pools'=>$this->integer()->notNull()->defaultValue(0),
            'homes'=>$this->integer()->notNull()->defaultValue(0),
            'furnished'=>$this->integer()->notNull(),
            'water_availability'=>$this->string()->null(),
            'status_of_electricity'=>$this->integer()->null(),
            'currency'=>$this->string(20)->null(),
            'currency_symbol'=>$this->string(5)->null(),
            'price'=>$this->integer()->null(),
            'property_video_link'=>$this->string()->null(),
            'property_type_id'=>$this->bigInteger()->notNull(),
            'property_category_id'=>$this->bigInteger()->notNull(),
            'construction_status_id'=>$this->bigInteger()->null(),
            'watermark_image' => $this->string(50)->null(),
            'status' => $this->string(15)->notNull(),
            'created_by'=>$this->bigInteger()->null(),
            'updated_by'=>$this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_rental-user_id',
            'mls_rental',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_rental-user_id',
            'mls_rental',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        
        // creates index for column `metric_type_id`
        $this->createIndex(
            'idx-mls_rental-metric_type_id',
            'mls_rental',
            'metric_type_id'
        );

        // add foreign key for table `mls_metric_type`
        $this->addForeignKey(
            'fk-mls_rental-metric_type_id',
            'mls_rental',
            'metric_type_id',
            'mls_metric_type',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_type_id`
        $this->createIndex(
            'idx-mls_rental-property_type_id',
            'mls_rental',
            'property_type_id'
        );

        // add foreign key for table `mls_rental_type`
        $this->addForeignKey(
            'fk-mls_rental-property_type_id',
            'mls_rental',
            'property_type_id',
            'mls_property_type',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_category_id`
        $this->createIndex(
            'idx-mls_rental-property_category_id',
            'mls_rental',
            'property_category_id'
        );

        // add foreign key for table `mls_rental_category`
        $this->addForeignKey(
            'fk-mls_rental-property_category_id',
            'mls_rental',
            'property_category_id',
            'mls_property_category',
            'id',
            'CASCADE'
        );
        
        // creates index for column `construction_status_id`
        $this->createIndex(
            'idx-mls_rental-construction_status_id',
            'mls_rental',
            'construction_status_id'
        );

        // add foreign key for table `mls_construction_status_master`
        $this->addForeignKey(
            'fk-mls_rental-construction_status_id',
            'mls_rental',
            'construction_status_id',
            'mls_construction_status_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_rental');
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
