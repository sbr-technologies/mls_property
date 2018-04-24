<?php

use yii\db\Migration;

class m170420_132400_add_slug_to_property extends Migration
{
    public function up()
    {
        $this->alterColumn( '{{%property}}', 'title', $this->string(255)->null()->after('user_id'));
        $this->addColumn('{{%property}}', 'slug', $this->string(255)->notNull()->after('title'));
        $this->addColumn('{{%property}}', 'no_of_garage', $this->integer()->notNull()->defaultValue(0)->after('no_of_bathroom'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'slug');
        $this->dropColumn('{{%property}}', 'no_of_garage');
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
