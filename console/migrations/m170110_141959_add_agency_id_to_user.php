<?php

use yii\db\Migration;

class m170110_141959_add_agency_id_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'agency_id', $this->bigInteger()->null()->after('profile_id'));
        // creates index for column `post_id`
        $this->createIndex(
            'idx-user-agency_id',
            '{{%user}}',
            'agency_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-user-agency_id',
            '{{%user}}',
            'agency_id',
            '{{%agency}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        echo "m170110_141959_add_agency_id_to_user cannot be reverted.\n";

        return false;
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
