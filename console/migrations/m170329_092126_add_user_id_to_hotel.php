<?php

use yii\db\Migration;

class m170329_092126_add_user_id_to_hotel extends Migration
{
    public function up()
    {
        $this->addColumn('{{%hotel}}', 'user_id', $this->bigInteger()->notNull()->after('id'));
        // creates index for column `post_id`
        $this->createIndex(
            'idx-hotel-user_id',
            '{{%hotel}}',
            'user_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-hotel-user_id',
            '{{%hotel}}',
            'user_id',
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
