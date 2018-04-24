<?php

use yii\db\Migration;

class m170104_112040_create_service_category extends Migration
{
    public function up()
    {
        $this->createTable('mls_service_category', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->null(),
            'status' => $this->string(15)->notNull(),
        ]);
        $this->batchInsert('{{%service_category}}', ['name', 'description','status'], [
            ['Property', '','active'],
            ['Hotel', '','active'],
            ['Holiday package', '','active'],
            ['Banner advertisement', '','active'],
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_service_category');
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
