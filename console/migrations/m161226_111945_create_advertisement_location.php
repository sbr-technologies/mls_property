<?php

use yii\db\Migration;

class m161226_111945_create_advertisement_location extends Migration
{
    public function up()
    {
        $this->createTable('mls_advertisement_location', [
            'id' => $this->bigPrimaryKey(),
            'ad_id' => $this->bigInteger()->notNull(),
            'location_id' => $this->bigInteger()->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
        
        // creates index for column `ad_id`
        $this->createIndex(
            'idx-mls_advertisement_location-ad_id',
            'mls_advertisement_location',
            'ad_id'
        );

        // add foreign key for table `mls_advertisement`
        $this->addForeignKey(
            'fk-mls_advertisement_location-ad_id',
            'mls_advertisement_location',
            'ad_id',
            'mls_advertisement',
            'id',
            'CASCADE'
        );
        
        // creates index for column `location_id`
        $this->createIndex(
            'idx-mls_advertisement_location-location_id',
            'mls_advertisement_location',
            'location_id'
        );

        // add foreign key for table `mls_advertisement`
        $this->addForeignKey(
            'fk-mls_advertisement_location-location_id',
            'mls_advertisement_location',
            'location_id',
            'mls_advertisement_location_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_advertisement_location');
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
