<?php

use yii\db\Migration;

class m170111_135042_create_location_local_info_type_master extends Migration
{
    public function up()
    {
        $this->createTable('{{%location_local_info_type_master}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string()->notNull(),
            'description'=>$this->text()->null(),
            'status' => $this->string(15)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->batchInsert('{{%location_local_info_type_master}}', ['title', 'description','status', 'created_at', 'updated_at'], [
            ['Bank', '','active', strtotime('now'), strtotime('now')],
            ['Hospital', '','active', strtotime('now'), strtotime('now')],  
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%location_local_info_type_master}}');
        
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
