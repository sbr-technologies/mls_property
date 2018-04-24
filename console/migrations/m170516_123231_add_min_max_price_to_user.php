<?php

use yii\db\Migration;

class m170516_123231_add_min_max_price_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'min_price', $this->integer()->notNull()->defaultValue(0)->after('price_range'));
        $this->addColumn('{{%user}}', 'max_price', $this->integer()->notNull()->defaultValue(0)->after('min_price'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'min_price');
        $this->dropColumn('{{%user}}', 'max_price');
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
