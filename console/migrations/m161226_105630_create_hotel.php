<?php

use yii\db\Migration;

class m161226_105630_create_hotel extends Migration
{
    public function up()
    {
        $this->createTable('mls_hotel', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull(),
            'tagline' => $this->string()->null(),
            'description' => $this->text()->null(),
            'country' => $this->string(75)->notNull(),
            'state' => $this->string(75)->notNull(),
            'city' => $this->string(75)->notNull(),
            'address1' => $this->string()->notNull(),
            'address2' => $this->string()->null(),
            'zip_code' => $this->string(15)->notNull(),
            'price'=> $this->decimal(7,2)->notNull(),
            'days_no'=> $this->integer()->notNull(),
            'night_no'=> $this->integer()->notNull(),
            'lat' => $this->double(7)->notNull(),
            'lng' => $this->double(7)->notNull(),
            'estd' => $this->string(50)->null(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_hotel');
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
