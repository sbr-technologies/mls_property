<?php

use yii\db\Migration;

class m170529_125413_add_status_update_rem_sent_at_to_property extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'rem_sent_at', $this->integer()->null()->after('total_reviews')->comment('Reminder email sent at'));
        $this->addColumn('{{%rental}}', 'rem_sent_at', $this->integer()->null()->after('watermark_image')->comment('Reminder email sent at'));
    }

    public function down()
    {
        $this->dropColumn('{{%property}}', 'rem_sent_at');
        $this->dropColumn('{{%rental}}', 'rem_sent_at');
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
