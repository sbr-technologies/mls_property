<?php

use yii\db\Migration;

class m170503_140414_create_room_type extends Migration
{
    public function up()
    {
        $this->createTable('mls_room_type', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(15)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_room_type');
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
