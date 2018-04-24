<?php

use yii\db\Migration;

class m161230_065117_create_plan_master extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_plan_master', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->string(100)->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->longText()->null(),
            'amount'=>$this->decimal(5,2)->notNull(),
            'duration'=>$this->integer()->notNull()->comment("In Days"),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_plan_master');
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
