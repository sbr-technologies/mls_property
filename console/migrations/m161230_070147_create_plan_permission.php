<?php

use yii\db\Migration;

class m161230_070147_create_plan_permission extends Migration
{
    public function up()
    {
        $this->createTable('mls_plan_permission', [
            'id' => $this->bigPrimaryKey(),
            'plan_id' => $this->bigInteger()->notNull(),
            'permission_id' => $this->bigInteger()->notNull(),
            'value' => $this->string()->notNull(50),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `plan_id`
        $this->createIndex(
            'idx-mls_plan_permission-plan_id',
            'mls_plan_permission',
            'plan_id'
        );

        // add foreign key for table `mls_plan_master`
        $this->addForeignKey(
            'fk-mls_plan_permission-post_id',
            'mls_plan_permission',
            'plan_id',
            'mls_plan_master',
            'id',
            'CASCADE'
        );
        
        // creates index for column `permission_id`
        $this->createIndex(
            'idx-mls_plan_permission-permission_id',
            'mls_plan_permission',
            'permission_id'
        );

        // add foreign key for table `mls_permission_master`
        $this->addForeignKey(
            'fk-mls_plan_permission-permission_id',
            'mls_plan_permission',
            'permission_id',
            'mls_permission_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_plan_permission');
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
