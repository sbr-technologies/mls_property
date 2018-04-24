<?php

use yii\db\Migration;

class m161226_111754_create_advertisement extends Migration
{
    public function up()
    {
        $this->createTable('mls_advertisement', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(100)->null(),
            'description' => $this->text()->null(),
            'link' => $this->string()->notNull(),
            'no_of_banner' => $this->integer()->notNull()->defaultValue(0),
            'profile_ids' => $this->string(50)->null(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_advertisement-user_id',
            'mls_advertisement',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_advertisement-user_id',
            'mls_advertisement',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_advertisement');
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
