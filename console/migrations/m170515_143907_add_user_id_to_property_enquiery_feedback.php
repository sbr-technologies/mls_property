<?php

use yii\db\Migration;

class m170515_143907_add_user_id_to_property_enquiery_feedback extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property_enquiery_feedback}}', 'user_id', $this->bigInteger()->notNull()->after('id'));
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_property_enquiery_feedback-user_id',
            'mls_property_enquiery_feedback',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_property_enquiery_feedback-user_id',
            'mls_property_enquiery_feedback',
            'user_id',
            'mls_user',
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
