<?php

use yii\db\Migration;

class m170424_093123_add_slug_to_rental extends Migration
{
    public function up()
    {
        $this->alterColumn( '{{%rental}}', 'title', $this->string(255)->null()->after('user_id'));
        $this->addColumn('{{%rental}}', 'slug', $this->string(255)->notNull()->after('title'));
        $this->addColumn('{{%rental}}', 'featured', $this->boolean()->notNull()->defaultValue(0)->after('price'));
    }

    public function down()
    {
        $this->dropColumn('{{%rental}}', 'slug');
        $this->dropColumn('{{%rental}}', 'featured');
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
