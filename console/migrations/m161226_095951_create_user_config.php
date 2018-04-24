<?php

use yii\db\Migration;

class m161226_095951_create_user_config extends Migration
{
    public function up()
    {
        $this->createTable('mls_user_config', [
            'id' => $this->bigPrimaryKey(),
            'user_id'=>$this->bigInteger()->notNull(),
            'title' => $this->string()->notNull(),
            'type' => $this->string(10)->notNull(),
            'key' => $this->string(128)->notNull(),
            'value' => $this->text()->notNull(),
            'tip' => $this->text()->null(),
            'options' => $this->string(128)->null(),
            'unit' => $this->string(128)->null(),
            'default' => $this->text()->null(),
            'status' => $this->string(15)->null(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_user_config-user_id',
            'mls_user_config',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_user_config-user_id',
            'mls_user_config',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_user_config');
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
