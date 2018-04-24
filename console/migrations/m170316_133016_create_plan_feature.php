<?php

use yii\db\Migration;

class m170316_133016_create_plan_feature extends Migration
{
    public function up()
    {
        $this->createTable('mls_plan_feature', [
            'id' => $this->bigPrimaryKey(),
            'plan_id' => $this->bigInteger()->notNull(),
            'description' => $this->string(255)->notNull(),
            'status' => $this->string(15)->null(),
            
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_plan_feature-plan_id',
            'mls_plan_feature',
            'plan_id'
        );

        // add foreign key for table `mls_plan_master`
        $this->addForeignKey(
            'fk-mls_plan_feature-plan_id',
            'mls_plan_feature',
            'plan_id',
            'mls_plan_master',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        echo "m170316_133016_create_plan_feature cannot be reverted.\n";

        return false;
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
