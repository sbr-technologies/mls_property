<?php

use yii\db\Migration;

class m161230_070653_create_subscription extends Migration
{
    public function up()
    {
        $this->createTable('mls_subscription', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'plan_id' => $this->bigInteger()->notNull(),
            'paid_amount'=>$this->decimal()->defaultValue(0),
            'subs_start'=>$this->integer()->notNull(),
            'subs_end'=>$this->integer()->notNull(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_subscription-user_id',
            'mls_subscription',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_subscription-user_id',
            'mls_subscription',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `plan_id`
        $this->createIndex(
            'idx-mls_subscription-plan_id',
            'mls_subscription',
            'plan_id'
        );

        // add foreign key for table `mls_permission_master`
        $this->addForeignKey(
            'fk-mls_subscription-plan_id',
            'mls_subscription',
            'plan_id',
            'mls_plan_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_subscription');
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
