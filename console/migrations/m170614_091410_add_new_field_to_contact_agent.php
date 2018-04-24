<?php

use yii\db\Migration;

class m170614_091410_add_new_field_to_contact_agent extends Migration
{
    public function up()
    {
        $this->addColumn('{{%contact_agent}}', 'login_user', $this->integer()->defaultValue(0)->after('status'));
        $this->addColumn('{{%contact_agent}}', 'privacy_policy', $this->integer()->defaultValue(0)->after('login_user'));
        $this->addColumn('{{%contact_agent}}', 'newsletter_send', $this->integer()->defaultValue(0)->after('privacy_policy'));
    }

    public function down()
    {
        $this->dropColumn('{{%contact_agent}}', 'login_user');
        $this->dropColumn('{{%contact_agent}}', 'privacy_policy');
        $this->dropColumn('{{%contact_agent}}', 'newsletter_send');
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
