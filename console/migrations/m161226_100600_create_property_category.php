<?php

use yii\db\Migration;

class m161226_100600_create_property_category extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_category', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->batchInsert('{{%property_category}}', ['title', 'description','status','created_by','updated_by', 'created_at', 'updated_at'], [
            ['For Rent', '','active','','', strtotime('now'), strtotime('now')],
            ['For Sale', '','active','','', strtotime('now'), strtotime('now')],
        ]);
    }
    

    public function down()
    {
        $this->dropTable('mls_property_category');
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
