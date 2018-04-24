<?php

use yii\db\Migration;

class m170406_060602_create_property_feature_master extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_feature_master', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(15)->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_property_feature_master');
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
