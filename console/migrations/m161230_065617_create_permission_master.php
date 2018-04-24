<?php

use yii\db\Migration;

class m161230_065617_create_permission_master extends Migration
{
    public function up()
    {
        $this->createTable('mls_permission_master', [
            'id' => $this->bigPrimaryKey(),
            'service_category_ids'=>$this->string(35)->notNull(),
            'name' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_permission_master');
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
