<?php

use yii\db\Migration;

class m170331_052239_add_featured_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'featured', $this->integer()->notNull()->defaultValue(0)->after('price'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'featured');
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
