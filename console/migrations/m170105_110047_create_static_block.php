<?php

use yii\db\Migration;

class m170105_110047_create_static_block extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('{{%static_block}}', [
            'id' => $this->bigPrimaryKey(),
            'block_location_id' => $this->bigInteger()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->longText()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `block_location_id`
        $this->createIndex(
            'idx-static_block-block_location_id',
            '{{%static_block}}',
            'block_location_id'
        );

        // add foreign key for table `mls_static_block_location_master`
        $this->addForeignKey(
            'fk-static_block-block_location_id',
            '{{%static_block}}',
            'block_location_id',
            '{{%static_block_location_master}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%static_block}}');
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
