<?php

use yii\db\Migration;

class m170731_123758_create_buyer_work_sheet extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function safeUp()
    {
        $this->createTable('{{%buyer_work_sheet}}', [
            'id'                    =>  $this->bigPrimaryKey(),
            'user_id'               =>  $this->bigInteger()->notNull(),
            'state'                 =>  $this->string(75)->null(),
            'lga'                   =>  $this->string(75)->null(),
            'city'                  =>  $this->string(75)->null(),
            'area'                  =>  $this->string(125)->null(),
            'comment_location'      =>  $this->longText()->null(),
            'price_range_from'      =>  $this->string(35)->null(),
            'price_range_to'        =>  $this->string(35)->null(),
            'how_soon_need'         =>  $this->string(75)->null(),
            'usage'                 =>  $this->string(75)->null(),
            'investment'            =>  $this->string(75)->null(),
            'cash_flow'             =>  $this->string(75)->null(),
            'appricition'           =>  $this->string(75)->null(),
            'need_agent'            =>  $this->string(15)->null(),
            'contact_me'            =>  $this->string(15)->null(),
            'year_built'            =>  $this->integer()->null(),
            'bed'                   =>  $this->string(15)->null(),
            'bath'                  =>  $this->string(15)->null(),
            'living'                =>  $this->string(15)->null(),
            'stories'               =>  $this->string(75)->null(),
            'square_footage'        =>  $this->string(25)->null(),
            'celling'               =>  $this->string(25)->null(),
            'feature_comment'       =>  $this->longText()->null(),
            'amenities_comment'     =>  $this->longText()->null(),
            'additional_criteria'   =>  $this->longText()->null(),
            'condition'             =>  $this->string(75)->null(),
            'commercial'            =>  $this->string(75)->null(),
            'demolition'            =>  $this->string(75)->null(),
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_buyer_work_sheet-user_id',
            'mls_buyer_work_sheet',
            'user_id'
        );

        // add foreign key for table `mls_property`
        $this->addForeignKey(
            'fk-mls_buyer_work_sheet-user_id',
            'mls_buyer_work_sheet',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('mls_buyer_work_sheet');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170731_123758_create_buyer_work_sheet cannot be reverted.\n";

        return false;
    }
    */
}
