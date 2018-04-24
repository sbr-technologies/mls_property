<?php

use yii\db\Migration;

class m170509_141917_add_recommend_count_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'recommend_count', $this->integer()->null()->after('price_range'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'recommend_count');
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
