<?php

use yii\db\Migration;

class m170731_131323_create_buyer_work_sheet_property_type extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%buyer_work_sheet_property_type}}', [
            'id'                    =>  $this->bigPrimaryKey(),
            'user_id'               =>  $this->bigInteger()->notNull(),
            'property_type_id'      =>  $this->bigInteger()->null(),
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_buyer_work_sheet_property_type-user_id',
            'mls_buyer_work_sheet',
            'user_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_buyer_work_sheet_property_type-user_id',
            'mls_buyer_work_sheet',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_buyer_work_sheet_property_type-property_type_id',
            'mls_buyer_work_sheet_property_type',
            'property_type_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_buyer_work_sheet_property_type-property_type_id',
            'mls_buyer_work_sheet_property_type',
            'property_type_id',
            'mls_property_type',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('mls_buyer_work_sheet_property_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170731_131323_create_buyer_work_sheet_property_type cannot be reverted.\n";

        return false;
    }
    */
}
