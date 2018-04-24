<?php

use yii\db\Migration;

class m170418_142440_add_tag_ids_to_discussion_post extends Migration
{
    public function up()
    {
        $this->addColumn('{{%discussion_post}}', 'tag_ids', $this->string(75)->null()->after('user_id'));
    }

    public function down()
    {
        $this->dropColumn('{{%discussion_post}}', 'tag_ids');
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
