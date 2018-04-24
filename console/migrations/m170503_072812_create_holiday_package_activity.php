<?php

use yii\db\Migration;

class m170503_072812_create_holiday_package_activity extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_holiday_package_activity', [
            'id' => $this->bigPrimaryKey(),
            'holiday_package_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->longText()->notNull(),
            
        ]);
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_holiday_package_activity-package_feature_id',
            'mls_holiday_package_activity',
            'holiday_package_id'
        );

        // add foreign key for table `mls_holiday_package`
        $this->addForeignKey(
            'fk-mls_holiday_package_activity-package_feature_id',
            'mls_holiday_package_activity',
            'holiday_package_id',
            'mls_holiday_package',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_holiday_package_activity');
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
