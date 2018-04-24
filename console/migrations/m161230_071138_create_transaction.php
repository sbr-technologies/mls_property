<?php

use yii\db\Migration;

class m161230_071138_create_transaction extends Migration
{
    public function up()
    {
        $this->createTable('mls_transaction', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'gateway' => $this->string(50)->notNull(),
            'transaction_id'=>$this->string(50),
            'paid_amount'=>$this->decimal()->defaultValue(0),
            'subs_start'=>$this->integer()->notNull(),
            'subs_end'=>$this->integer()->notNull(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_transaction-user_id',
            'mls_transaction',
            'user_id'
        );

        // add foreign key for table `mls_plan_master`
        $this->addForeignKey(
            'fk-mls_transaction-user_id',
            'mls_transaction',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_transaction');
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
