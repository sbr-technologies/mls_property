<?php

use yii\db\Migration;

class m170112_101549_create_fact_master extends Migration
{
    public function up()
    {
        $this->createTable('{{%fact_master}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string()->notNull(),
            'description'=>$this->text()->null(),
            'status' => $this->string(15)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->batchInsert('{{%fact_master}}', ['title', 'description','status', 'created_at', 'updated_at'], [
            ['Xxxxxx', '','active', strtotime('now'), strtotime('now')],
            ['Yyyyyy', '','active', strtotime('now'), strtotime('now')],  
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%fact_master}}');
        
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
