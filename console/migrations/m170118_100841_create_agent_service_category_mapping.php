<?php

use yii\db\Migration;

class m170118_100841_create_agent_service_category_mapping extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%agent_service_category_mapping}}', [
            'id' => $this->bigPrimaryKey(),
            'agent_id' => $this->bigInteger()->notNull(),
            'service_category_id' => $this->bigInteger()->notNull()
        ]);
        
        // creates index for column `seller_id`
        $this->createIndex(
            'idx-agent_service_category_mapping-service_category_id',
            '{{%agent_service_category_mapping}}',
            'service_category_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-agent_service_category_mapping-service_category_id',
            '{{%agent_service_category_mapping}}',
            'service_category_id',
            '{{%service_category}}',
            'id',
            'CASCADE'
        );
        
        // creates index for column `seller_id`
        $this->createIndex(
            'idx-agent_service_category_mapping-agent_id',
            '{{%agent_service_category_mapping}}',
            'agent_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-agent_service_category_mapping-agent_id',
            '{{%agent_service_category_mapping}}',
            'agent_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        
    }

    public function down()
    {
       
        $this->dropTable('{{%agent_service_category_mapping}}');
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
