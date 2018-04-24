<?php

use yii\db\Migration;

class m170519_091811_create_electricity_type extends Migration
{
    public function up(){
        $this->dropColumn('{{%property}}', 'status_of_electricity');
        $this->addColumn('{{%property}}', 'electricity_type_ids', $this->string()->notNull()->after('water_availability'));
        $this->createTable('{{%electricity_type}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(100)->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%electricity_type}}');
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
