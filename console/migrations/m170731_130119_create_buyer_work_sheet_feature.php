<?php

use yii\db\Migration;

class m170731_130119_create_buyer_work_sheet_feature extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%buyer_work_sheet_feature}}', [
            'id'                    =>  $this->bigPrimaryKey(),
            'user_id'               =>  $this->bigInteger()->notNull(),
            'feature'               =>  $this->string(75)->null(),
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_buyer_work_sheet_feature-user_id',
            'mls_buyer_work_sheet_feature',
            'user_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_buyer_work_sheet_feature-user_id',
            'mls_buyer_work_sheet_feature',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('mls_buyer_work_sheet_feature');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170731_130119_create_buyer_work_sheet_feature cannot be reverted.\n";

        return false;
    }
    */
}
