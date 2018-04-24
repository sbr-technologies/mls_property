<?php

use yii\db\Migration;

class m170124_053416_create_hotel_owner_service_category_mapping extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%hotel_owner_service_category_mapping}}', [
            'id' => $this->bigPrimaryKey(),
            'hotel_owner_id' => $this->bigInteger()->notNull(),
            'service_category_id' => $this->bigInteger()->notNull()
        ]);
        
        // creates index for column `service_category_id`
        $this->createIndex(
            'idx-hotel_owner_service_category_mapping-service_category_id',
            '{{%hotel_owner_service_category_mapping}}',
            'service_category_id'
        );

        // add foreign key for table `service_category`
        $this->addForeignKey(
            'fk-hotel_owner_service_category_mapping-service_category_id',
            '{{%hotel_owner_service_category_mapping}}',
            'service_category_id',
            '{{%service_category}}',
            'id',
            'CASCADE'
        );
        
        // creates index for column `hotel_owner_id`
        $this->createIndex(
            'idx-hotel_owner_service_category_mapping-hotel_owner_id',
            '{{%hotel_owner_service_category_mapping}}',
            'hotel_owner_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-hotel_owner_service_category_mapping-hotel_owner_id',
            '{{%hotel_owner_service_category_mapping}}',
            'hotel_owner_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        
    }

    public function down()
    {
       
        $this->dropTable('{{%hotel_owner_service_category_mapping}}');
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
