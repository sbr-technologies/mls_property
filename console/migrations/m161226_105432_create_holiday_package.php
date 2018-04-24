<?php

use yii\db\Migration;

class m161226_105432_create_holiday_package extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_holiday_package', [
            'id' => $this->bigPrimaryKey(),
            'category_id' => $this->bigInteger()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->null(),
            'package_amount' => $this->decimal(7,2)->notNull(),
            'no_of_days' => $this->smallInteger()->notNull()->defaultValue(0),
            'no_of_nights' => $this->smallInteger()->notNull()->defaultValue(0),
            'hotel_transport_info' => $this->text()->null(),
            'departure_date' => $this->integer()->notNull(),
            'inclusion' => $this->text()->null(),
            'exclusions' => $this->text()->null(),
            'payment_policy' => $this->longText()->null(),
            'cancellation_policy' => $this->longText()->null(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `category_id`
        $this->createIndex(
            'idx-mls_holiday_package-category_id',
            'mls_holiday_package',
            'category_id'
        );

        // add foreign key for table `mls_holiday_package_category`
        $this->addForeignKey(
            'fk-mls_holiday_package-category_id',
            'mls_holiday_package',
            'category_id',
            'mls_holiday_package_category',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_holiday_package');
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
