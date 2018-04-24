<?php

use yii\db\Migration;

class m170418_160510_add_category_id_to_discussion_post extends Migration
{
    public function up()
    {
        $this->addColumn('{{%discussion_post}}', 'category_id', $this->bigInteger()->notNull()->after('user_id'));
        
        $this->createIndex(
            'idx-discussion_post-category_id',
            '{{%discussion_post}}',
            'category_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-discussion_post-category_id',
            '{{%discussion_post}}',
            'category_id',
            '{{%discussion_category}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropColumn('{{%discussion_post}}', 'category_id');
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
