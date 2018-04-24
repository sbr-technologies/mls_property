<?php

use yii\db\Migration;

class m170329_125722_add_user_id_to_hoilday_package extends Migration
{
    public function up(){
        $this->addColumn('{{%holiday_package}}', 'user_id', $this->bigInteger()->notNull()->after('id'));
        // creates index for column `post_id`
        $this->createIndex(
            'idx-holiday_package-user_id',
            '{{%holiday_package}}',
            'user_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-holiday_package-user_id',
            '{{%holiday_package}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down(){
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
