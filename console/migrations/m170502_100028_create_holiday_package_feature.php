<?php

use yii\db\Migration;

class m170502_100028_create_holiday_package_feature extends Migration
{
    public function up()
    {
        $this->createTable('mls_holiday_package_feature', [
            'id' => $this->bigPrimaryKey(),
            'holiday_package_id' => $this->bigInteger()->notNull(),
            'holiday_package_type_id' => $this->bigInteger()->notNull(),
        ]);
        // creates index for column `holiday_package_id`
        $this->createIndex(
            'idx-mls_holiday_package_feature-holiday_package_id',
            'mls_holiday_package_feature',
            'holiday_package_id'
        );

        // add foreign key for table `mls_holiday_package_feature`
        $this->addForeignKey(
            'fk-mls_holiday_package_feature-holiday_package_id',
            'mls_holiday_package_feature',
            'holiday_package_id',
            'mls_holiday_package',
            'id',
            'CASCADE'
        );
        
        // creates index for column `holiday_package_id`
        $this->createIndex(
            'idx-mls_holiday_package_feature-holiday_package_type_id',
            'mls_holiday_package_feature',
            'holiday_package_type_id'
        );

        // add foreign key for table `mls_holiday_package_feature`
        $this->addForeignKey(
            'fk-mls_holiday_package_feature-holiday_package_type_id',
            'mls_holiday_package_feature',
            'holiday_package_type_id',
            'mls_holiday_package_type',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_holiday_package_feature');
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
