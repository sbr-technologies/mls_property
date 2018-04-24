<?php

use yii\db\Migration;

class m161226_111259_create_holiday_package_enquiry extends Migration
{
    public function up()
    {
        $this->createTable('mls_holiday_package_enquiry', [
            'id' => $this->bigPrimaryKey(),
            'holiday_package_id' => $this->bigInteger()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull(),
            'enquiry_at' => $this->integer()->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
        
        // creates index for column `holiday_package_id`
        $this->createIndex(
            'idx-mls_holiday_package_enquiry-holiday_package_id',
            'mls_holiday_package_enquiry',
            'holiday_package_id'
        );

        // add foreign key for table `mls_holiday_package`
        $this->addForeignKey(
            'fk-mls_holiday_package_enquiry-holiday_package_id',
            'mls_holiday_package_enquiry',
            'holiday_package_id',
            'mls_holiday_package',
            'id',
            'CASCADE'
        );
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_holiday_package_enquiry-user_id',
            'mls_holiday_package_enquiry',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_holiday_package_enquiry-user_id',
            'mls_holiday_package_enquiry',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_holiday_package_enquiry');
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
