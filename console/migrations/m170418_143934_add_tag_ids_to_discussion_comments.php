<?php

use yii\db\Migration;

class m170418_143934_add_tag_ids_to_discussion_comments extends Migration
{
    public function up()
    {
        $this->addColumn('{{%discussion_comment}}', 'tag_ids', $this->string(75)->null()->after('user_id'));
    }

    public function down()
    {
        $this->dropColumn('{{%discussion_comment}}', 'tag_ids');
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
