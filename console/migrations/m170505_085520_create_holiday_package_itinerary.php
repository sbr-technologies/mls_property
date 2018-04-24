<?php

use yii\db\Migration;

class m170505_085520_create_holiday_package_itinerary extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function safeUp()
    {
        $this->dropForeignKey('fk-mls_holiday_package_activity-package_feature_id','{{%holiday_package_activity}}');
        $this->dropTable('mls_holiday_package_activity');
        $this->createTable('mls_holiday_package_itinerary', [
            'id' => $this->bigPrimaryKey(),
            'holiday_package_id' => $this->bigInteger()->notNull(),
            'days_name' => $this->string(35)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->longText()->notNull(),
            'address' => $this->string(125)->notNull(),
            'city' => $this->string(75)->notNull(),
            'state' => $this->string(75)->notNull(),
            'country' => $this->string(75)->notNull(),
            
        ]);
        
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_holiday_package_itinerary-holiday_package_id',
            'mls_holiday_package_itinerary',
            'holiday_package_id'
        );

        // add foreign key for table `mls_holiday_package`
        $this->addForeignKey(
            'fk-mls_holiday_package_itinerary-holiday_package_id',
            'mls_holiday_package_itinerary',
            'holiday_package_id',
            'mls_holiday_package',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('mls_holiday_package_itinerary');
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
