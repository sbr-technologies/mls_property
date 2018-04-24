<?php

use yii\db\Migration;

class m161226_093539_create_banner extends Migration
{
    public function up()
    {
        $this->createTable('mls_banner', [
            'id' => $this->bigPrimaryKey(),
            'property_id' => $this->bigInteger()->null(),
            'title' => $this->string(100)->null(),
            'description' => $this->string()->null(),
            'text_color' => $this->string(10)->null(),
            'sort_order' => $this->integer()->notNull()->defaultValue(999),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_banner');
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
