<?php

use yii\db\Migration;

class m170615_074514_create_general_feature_master extends Migration
{
    public function up()
    {
        $this->createTable('{{%general_feature_master}}', [
            'id'                =>  $this->bigPrimaryKey(),
            'type'              =>  $this->string(75)->notNull(),
            'name'              =>  $this->string(75)->notNull(),
            'status'            =>  $this->string(75)->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%general_feature_master}}');
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
