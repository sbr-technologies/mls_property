<?php

use yii\db\Migration;

class m170605_084426_create_about_seller extends Migration
{
    public function up()
    {
        $this->createTable('mls_about_seller', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'property_type_id' => $this->string(75)->notNull(),
            'price_range'=>$this->string(75)->null(),
            'duration'=>$this->string(75)->null(),
            'uses'=>$this->string(75)->null(),
            'occupation'=>$this->string()->null(),
            'salary_income' => $this->string(125)->null(),
            'need_agent' => $this->integer()->notNull(),
            'contact_me' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_about_seller-user_id',
            'mls_about_seller',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_about_seller-user_id',
            'mls_about_seller',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_about_seller');
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
