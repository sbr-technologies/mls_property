<?php

use yii\db\Migration;

class m170118_094942_create_agent_seller_mapping extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%agent_seller_mapping}}', [
            'id' => $this->bigPrimaryKey(),
            'agent_id' => $this->bigInteger()->notNull(),
            'seller_id' => $this->bigInteger()->notNull()
        ]);
        
        // creates index for column `seller_id`
        $this->createIndex(
            'idx-agent_seller_mapping-seller_id',
            '{{%agent_seller_mapping}}',
            'seller_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-agent_seller_mapping-seller_id',
            '{{%agent_seller_mapping}}',
            'seller_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        
        // creates index for column `seller_id`
        $this->createIndex(
            'idx-agent_seller_mapping-agent_id',
            '{{%agent_seller_mapping}}',
            'agent_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-agent_seller_mapping-agent_id',
            '{{%agent_seller_mapping}}',
            'agent_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        
    }

    public function down()
    {
        
        $this->dropTable('{{%agent_seller_mapping}}');
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
