<?php

use yii\db\Migration;

class m170322_113132_create_advice_category extends Migration
{
    public function up()
    {
        $this->createTable('mls_advice_category', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_advice_category');
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
