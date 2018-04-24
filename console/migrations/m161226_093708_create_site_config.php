<?php

use yii\db\Migration;

class m161226_093708_create_site_config extends Migration
{
    public function safeUp()
    {
        $this->createTable('mls_site_config', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string()->notNull(),
            'type' => $this->string(10)->notNull(),
            'key' => $this->string(128)->notNull(),
            'value' => $this->text()->notNull(),
            'tip' => $this->text()->null(),
            'options' => $this->string(128)->notNull(),
            'unit' => $this->string(128)->null(),
            'default' => $this->text()->null(),
            'status' => $this->string(15)->null(),
        ]);
        
        $this->batchInsert('{{%site_config}}', ['title', 'type', 'key','value', 'tip', 'options', 'unit', 'default', 'status'], [
            ['Enable User Verification', 'select', 'userVerification', 'no', NULL, 'yes|no', NULL, NULL, 1],
            ['Allowed Extensions for Images', 'multi', 'allowedImageExt', 'png|jpeg|jpg|gif', NULL, 'png|jpeg|jpg|gif', NULL, NULL, 0],
            ['Autoapprove Feedback?', 'select', 'feedbackAutoapprove', 'yes', NULL, 'yes|no', NULL, NULL, 0],
            ['Admin Email', 'text', 'adminEmail', 'cs@mls.com', NULL, '', NULL, NULL, 0],
            ['Email sender name', 'text', 'emailSender', 'MLS Property Team', NULL, '', NULL, NULL, 0],
            ['Default Timezone', 'text', 'defaultTimezone', 'Asia/Kolkata', NULL, '', NULL, NULL, 1],
            ['Facebook Social Media', 'text', 'facebookLink', 'http://facebook.com', NULL, '', NULL, NULL, 1],
            ['Twitter Social Media', 'text', 'twitterLink', 'http://twitter.com', NULL, '', NULL, NULL, 1],
            ['LinkedIn Social Media', 'text', 'linkedinLink', 'http://linkedin.com', NULL, '', NULL, NULL, 1],
            ['Instagram Social Media', 'text', 'instagramLink', 'http://instagram.com', NULL, '', NULL, NULL, 1],
            ['Instagram Social Media', 'text', 'instagramLink', 'http://instagram.com', NULL, '', NULL, NULL, 1]
        ]);
    }
    public function safeDown()
    {
        $this->dropTable('mls_site_config');
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
