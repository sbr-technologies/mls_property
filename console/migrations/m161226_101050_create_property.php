<?php

use yii\db\Migration;

class m161226_101050_create_property extends Migration
{
    public function up()
    {
        $this->createTable('{{%property}}', [
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
            'size' => $this->decimal(7,2)->notNull(),
            'lot_area' => $this->decimal(5,2)->notNull(),
            'no_of_room'=>$this->integer()->notNull(),
            'no_of_balcony'=>$this->integer()->null(),
            'no_of_bathroom'=>$this->integer()->null(),
            'lift'=>$this->integer()->notNull(),
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
            'idx-mls_property-user_id',
            'mls_property',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_property-user_id',
            'mls_property',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        
        // creates index for column `metric_type_id`
        $this->createIndex(
            'idx-mls_property-metric_type_id',
            'mls_property',
            'metric_type_id'
        );

        // add foreign key for table `mls_metric_type`
        $this->addForeignKey(
            'fk-mls_property-metric_type_id',
            'mls_property',
            'metric_type_id',
            'mls_metric_type',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_type_id`
        $this->createIndex(
            'idx-mls_property-property_type_id',
            'mls_property',
            'property_type_id'
        );

        // add foreign key for table `mls_property_type`
        $this->addForeignKey(
            'fk-mls_property-property_type_id',
            'mls_property',
            'property_type_id',
            'mls_property_type',
            'id',
            'CASCADE'
        );
        
        // creates index for column `property_category_id`
        $this->createIndex(
            'idx-mls_property-property_category_id',
            'mls_property',
            'property_category_id'
        );

        // add foreign key for table `mls_property_category`
        $this->addForeignKey(
            'fk-mls_property-property_category_id',
            'mls_property',
            'property_category_id',
            'mls_property_category',
            'id',
            'CASCADE'
        );
        
        // creates index for column `construction_status_id`
        $this->createIndex(
            'idx-mls_property-construction_status_id',
            'mls_property',
            'construction_status_id'
        );

        // add foreign key for table `mls_construction_status_master`
        $this->addForeignKey(
            'fk-mls_property-construction_status_id',
            'mls_property',
            'construction_status_id',
            'mls_construction_status_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_property');
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
