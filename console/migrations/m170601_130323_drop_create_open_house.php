<?php

use yii\db\Migration;

class m170601_130323_drop_create_open_house extends Migration
{
    public function up()
    {
        $this->dropTable('mls_open_house');
        $this->createTable('mls_open_house', [
            'id' => $this->bigPrimaryKey(),
            'model' => $this->string(100)->null(),
            'model_id' => $this->bigInteger()->null(),
            'start_date' => $this->date()->null(),
            'end_date' => $this->date()->null(),
            'start_time' => $this->time()->null(),
            'end_time' => $this->time()->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_open_house');
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
