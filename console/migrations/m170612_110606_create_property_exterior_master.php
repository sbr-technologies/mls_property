<?php

use yii\db\Migration;

class m170612_110606_create_property_exterior_master extends Migration
{
    public function up()
    {
        $this->createTable('{{%property_exterior_master}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%property_exterior_master}}');
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
