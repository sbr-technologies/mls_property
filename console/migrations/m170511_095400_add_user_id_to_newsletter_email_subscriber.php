<?php

use yii\db\Migration;

class m170511_095400_add_user_id_to_newsletter_email_subscriber extends Migration
{
    public function up()
    {
        $this->addColumn('{{%newsletter_email_subscriber}}', 'user_id', $this->bigInteger()->null()->after('id')->comment('Id of the owner of mini-website'));
        
        $this->createIndex(
            'idx-newsletter_email_subscriber-user_id',
            '{{%newsletter_email_subscriber}}',
            'user_id'
        );

        // add foreign key for table `mls_rental_feature_item`
        $this->addForeignKey(
            'fk-newsletter_email_subscriber-user_id',
            '{{%newsletter_email_subscriber}}',
            'user_id',
            '{{%user}}',
            'id',
            'SET NULL'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-newsletter_email_subscriber-user_id', '{{%newsletter_email_subscriber}}');
        $this->dropColumn('{{%newsletter_email_subscriber}}', 'user_id');
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
