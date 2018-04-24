<?php

use yii\db\Migration;

class m170510_085840_add_name_to_static_block extends Migration
{
    public function up()
    {
        $this->addColumn('{{%static_block}}', 'name', $this->string(255)->null()->after('title'));
    }

    public function down()
    {
        $this->dropColumn('{{%static_block}}', 'name');
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
