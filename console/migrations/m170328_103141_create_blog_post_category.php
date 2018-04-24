<?php

use yii\db\Migration;

class m170328_103141_create_blog_post_category extends Migration
{
    public function up()
    {
        $this->createTable('{{%blog_post_category}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(75)->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
        $this->addColumn('{{%blog_post}}', 'category_id', $this->bigInteger()->notNull()->after('id'));
        // creates index for column `post_id`
        $this->createIndex(
            'idx-blog_post-category_id',
            '{{%blog_post}}',
            'category_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-blog_post-category_id',
            '{{%blog_post}}',
            'category_id',
            '{{%blog_post_category}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%blog_post_category}}');
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
