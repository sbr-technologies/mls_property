<?php

use yii\db\Migration;

class m170517_065611_add_last_activity_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'last_activity', $this->string(32)->null()->after('max_price'));
        $this->addColumn('{{%user}}', 'last_activity_at', $this->integer()->null()->after('last_activity'));
        $this->addColumn('{{%user}}', 'total_listings', $this->integer()->notNull()->defaultValue(0)->after('total_recommendations'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'last_activity');
        $this->dropColumn('{{%user}}', 'last_activity_at');
        $this->dropColumn('{{%user}}', 'total_listing');
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
