<?php

use yii\db\Migration;

class m161226_105051_create_holiday_package_category extends Migration
{
    public function up()
    {
        $this->createTable('mls_holiday_package_category', [
            'id' => $this->bigPrimaryKey(),
            'parent_id' => $this->bigInteger()->null(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `parent_id`
        $this->createIndex(
            'idx-mls_holiday_package_category-parent_id',
            'mls_holiday_package_category',
            'parent_id'
        );

        // add foreign key for table `mls_holiday_package_category`
        $this->addForeignKey(
            'fk-mls_holiday_package_category-parent_id',
            'mls_holiday_package_category',
            'parent_id',
            'mls_holiday_package_category',
            'id',
            'CASCADE'
        );
        
        
    }

    public function down()
    {
        $this->dropTable('mls_holiday_package_category');
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
