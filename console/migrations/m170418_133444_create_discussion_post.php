<?php

use yii\db\Migration;

class m170418_133444_create_discussion_post extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_discussion_post', [
            'id' => $this->bigPrimaryKey(),
            'user_id'=>$this->bigInteger()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->longText()->notNull(),
            'slug' => $this->string()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_discussion_post-user_id',
            'mls_discussion_post',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_discussion_post-user_id',
            'mls_discussion_post',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
       $this->dropTable('mls_discussion_post');
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
