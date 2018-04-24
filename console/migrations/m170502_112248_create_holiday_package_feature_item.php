<?php

use yii\db\Migration;

class m170502_112248_create_holiday_package_feature_item extends Migration
{
    public function up()
    {
        $this->createTable('mls_holiday_package_feature_item', [
            'id' => $this->bigPrimaryKey(),
            'package_feature_id' => $this->bigInteger()->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_holiday_package_feature_item-package_feature_id',
            'mls_holiday_package_feature_item',
            'package_feature_id'
        );

        // add foreign key for table `mls_rental_feature_item`
        $this->addForeignKey(
            'fk-mls_holiday_package_feature_item-package_feature_id',
            'mls_holiday_package_feature_item',
            'package_feature_id',
            'mls_holiday_package_feature',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_holiday_package_feature_item');
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
