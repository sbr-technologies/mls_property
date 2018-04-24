<?php

use yii\db\Migration;

class m161226_102748_create_login_log extends Migration
{
    public function up()
    {
        $this->createTable('mls_login_log', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'login_time' => $this->integer()->notNull(),
            'logout_time' => $this->integer()->notNull(),
            'login_ip' => $this->string(15)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_login_log-user_id',
            'mls_login_log',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_login_log-user_id',
            'mls_login_log',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_login_log');
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
