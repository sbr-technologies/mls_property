<?php

use yii\db\Migration;

class m170105_105545_create_static_block_location_master extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%static_block_location_master}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(128)->notNull(),
            'code' => $this->string(50)->notNull(),
            'description' => $this->string(32)->null(),
        ]);
        
        $this->batchInsert('{{%static_block_location_master}}', ['title', 'code'], [
            ['Home Page', 'HomePage']
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%static_block_location_master}}');
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
