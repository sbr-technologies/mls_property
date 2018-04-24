<?php

use yii\db\Migration;

class m170418_133459_create_discussion_comment extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_discussion_comment', [
            'id' => $this->bigPrimaryKey(),
            'user_id'=>$this->bigInteger()->notNull(),
            'post_id'=>$this->bigInteger()->notNull(),
            'content' => $this->longText()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_discussion_comment-user_id',
            'mls_discussion_comment',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_discussion_comment-user_id',
            'mls_discussion_comment',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_discussion_comment-post_id',
            'mls_discussion_comment',
            'post_id'
        );

        // add foreign key for table `mls_blog_post`
        $this->addForeignKey(
            'fk-mls_discussion_comment-post_id',
            'mls_discussion_comment',
            'post_id',
            'mls_discussion_post',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_discussion_comment');
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
