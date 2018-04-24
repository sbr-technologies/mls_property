<?php

use yii\db\Migration;

class m170111_140044_create_property_location_local_info extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_location_local_info', [
            'id' => $this->bigPrimaryKey(),
            'property_id' => $this->bigInteger()->notNull(),
            'local_info_type_id' => $this->bigInteger()->notNull(),
            'title' => $this->string()->notNull(),
            'location'=>$this->string()->null(),
            'description'=>$this->text()->null(),
            'distance' => $this->decimal(7, 2)->null(),
            'lat' => $this->double(10,7)->null(),
            'lng' => $this->double(10,7)->null(),
            'status' => $this->string(15)->notNull(),
        ]);
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_property_location_local_info-property_id',
            'mls_property_location_local_info',
            'property_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_property_location_local_info-property_id',
            'mls_property_location_local_info',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
        // creates index for column `local_info_type_id`
        $this->createIndex(
            'idx-mls_property_location_local_info-local_info_type_id',
            'mls_property_location_local_info',
            'local_info_type_id'
        );

        // add foreign key for table `location_local_info_type_master`
        $this->addForeignKey(
            'fk-mls_property_location_local_info-local_info_type_id',
            'mls_property_location_local_info',
            'local_info_type_id',
            'mls_location_local_info_type_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_property_location_local_info');
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
