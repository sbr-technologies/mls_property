<?php

use yii\db\Migration;

class m170515_132546_add_total_recommendations_to_user extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%user}}', 'recommend_count');
        $this->addColumn('{{%user}}', 'total_recommendations', $this->integer()->notNull()->defaultValue(0)->after('total_reviews'));
    }

    public function down()
    {
        $this->addColumn('{{%user}}', 'recommend_count', $this->integer()->null()->after('price_range'));
        $this->dropColumn('{{%user}}', 'total_recommendations');
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
