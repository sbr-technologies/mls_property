<?php

use yii\db\Migration;

class m170408_103113_add_user_id_to_property_showing_request extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property_showing_request}}', 'request_to', $this->bigInteger()->notNull()->after('user_id'));
        // creates index for column `post_id`
        $this->createIndex(
            'idx-property_showing_request-request_to',
            '{{%property_showing_request}}',
            'request_to'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-property_showing_request-request_to',
            '{{%property_showing_request}}',
            'request_to',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
       
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
