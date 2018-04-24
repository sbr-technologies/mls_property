<?php

use yii\db\Migration;

class m170119_094951_create_seller_service_category_mapping extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%seller_service_category_mapping}}', [
            'id' => $this->bigPrimaryKey(),
            'seller_id' => $this->bigInteger()->notNull(),
            'service_category_id' => $this->bigInteger()->notNull()
        ]);
        
        // creates index for column `service_category_id`
        $this->createIndex(
            'idx-seller_service_category_mapping-service_category_id',
            '{{%seller_service_category_mapping}}',
            'service_category_id'
        );

        // add foreign key for table `service_category`
        $this->addForeignKey(
            'fk-seller_service_category_mapping-service_category_id',
            '{{%seller_service_category_mapping}}',
            'service_category_id',
            '{{%service_category}}',
            'id',
            'CASCADE'
        );
        
        // creates index for column `seller_id`
        $this->createIndex(
            'idx-seller_service_category_mapping-seller_id',
            '{{%seller_service_category_mapping}}',
            'seller_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-seller_service_category_mapping-seller_id',
            '{{%seller_service_category_mapping}}',
            'seller_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        
    }

    public function down()
    {
       
        $this->dropTable('{{%seller_service_category_mapping}}');
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
