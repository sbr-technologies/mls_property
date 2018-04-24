<?php

use yii\db\Migration;

class m170502_095654_create_holiday_package_type extends Migration
{
    public function up()
    {
        $this->createTable('mls_holiday_package_type', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(15)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_holiday_package_type');
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
