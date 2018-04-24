<?php

use yii\db\Migration;

class m161226_102035_create_agency extends Migration
{
    public function up()
    {
        $this->createTable('mls_agency', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(100)->notNull(),
            'tagline' => $this->string()->null(),
            'owner_name' => $this->string(100)->notNull(),
            'country' => $this->string(75)->notNull(),
            'state' => $this->string(75)->notNull(),
            'city' => $this->string(75)->notNull(),
            'address1' => $this->string()->notNull(),
            'address2' => $this->string()->null(),
            'zip_code' => $this->string(15)->notNull(),
            'lat' => $this->double(7)->notNull(),
            'lng' => $this->double(7)->notNull(),
            'estd' => $this->string(50)->null(),
            'status' => $this->string(15)->null(),
            'email' => $this->string(75)->null(),
            'mobile' => $this->string(35)->null(),
            'fax' => $this->string(35)->null(),
            'telephone' => $this->string(35)->null(),
            'web_address' => $this->string(75)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }
    
    public function down()
    {
        $this->dropTable('mls_agency');
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
