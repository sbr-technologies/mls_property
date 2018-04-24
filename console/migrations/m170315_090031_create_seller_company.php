<?php

use yii\db\Migration;

class m170315_090031_create_seller_company extends Migration
{
    public function up()
    {
        $this->createTable('mls_seller_company', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'name' => $this->string(255)->notNull(),
            'country' => $this->string(75)->notNull(),
            'state' => $this->string(75)->notNull(),
            'city' => $this->string(75)->notNull(),
            'address1' => $this->string()->notNull(),
            'address2' => $this->string()->null(),
            'zip_code' => $this->string(15)->notNull(),
            'estd' => $this->string(50)->null(),
            'email' => $this->string(75)->null(),
            'mobile' => $this->string(35)->null(),
            'fax' => $this->string(35)->null(),
            'telephone' => $this->string(35)->null(),
            'web_address' => $this->string(75)->null(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_seller_company-user_id',
            'mls_seller_company',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_seller_company-user_id',
            'mls_seller_company',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_seller_company');
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
