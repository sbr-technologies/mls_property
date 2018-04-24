<?php

use yii\db\Migration;

class m161226_092817_create_construction_status_master extends Migration
{
    public function up()
    {
        $this->createTable('mls_construction_status_master', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        $this->batchInsert('{{%construction_status_master}}', ['title','description','status','created_by','updated_by', 'created_at', 'updated_at'], [
            ['Under Construction', '','active','','', strtotime('now'), strtotime('now')],
            ['New Development', '','active','','', strtotime('now'), strtotime('now')],
            ['To Be Built', '','active','','', strtotime('now'), strtotime('now')],
            ['Previously owned', '','active','','', strtotime('now'), strtotime('now')],
            ['Model (for Sale)', '','active','','', strtotime('now'), strtotime('now')],
            ['Model (Not for Sale)', '','active','','', strtotime('now'), strtotime('now')],
            
        ]);
    }
    public function down()
    {
        $this->dropTable('mls_construction_status_master');
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
