<?php

use yii\db\Migration;

class m170417_121736_create_rental_plan extends Migration
{
    public function up()
    {
        $this->createTable('mls_rental_plan', [
            'id' => $this->bigPrimaryKey(),
            'rental_plan_id' => $this->bigInteger()->notNull(),
            'rental_id' => $this->bigInteger()->notNull(),
            'name' =>   $this->string(255)->notNull(),
            'bed' => $this->integer()->notNull(),
            'bath'=> $this->integer()->notNull(),
            'size' => $this->string(150)->notNull(),
            'price' => $this->integer()->null(),
            'status' => $this->string(15)->notNull(),
        ]);
        
        // creates index for column `rental_plan_id`
        $this->createIndex(
            'idx-mls_rental_plan-rental_plan_id',
            'mls_rental_plan',
            'rental_plan_id'
        );

        // add foreign key for table `mls_rental_plan_type`
        $this->addForeignKey(
            'fk-mls_rental_plan-rental_plan_id',
            'mls_rental_plan',
            'rental_plan_id',
            'mls_rental_plan_type',
            'id',
            'CASCADE'
        );
        
        
        // creates index for column `rental_id`
        $this->createIndex(
            'idx-mls_rental_plan-rental_id',
            'mls_rental_plan',
            'rental_id'
        );

        // add foreign key for table `mls_metric_type`
        $this->addForeignKey(
            'fk-mls_rental_plan-rental_id',
            'mls_rental_plan',
            'rental_id',
            'mls_rental',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_rental_plan');
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
