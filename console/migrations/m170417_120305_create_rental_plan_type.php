<?php

use yii\db\Migration;

class m170417_120305_create_rental_plan_type extends Migration
{
    public function up()
    {
        $this->createTable('mls_rental_plan_type', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(15)->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_rental_plan_type');
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
