<?php

use yii\db\Migration;

class m170403_102251_create_menu extends Migration
{
    public function up()
    {
        $this->createTable('mls_menu', [
            'id' => $this->bigPrimaryKey(),
            'parent_id'=> $this->bigInteger()->null(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'link' => $this->string(150)->null(),
            'status' => $this->string(15)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_menu');
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
