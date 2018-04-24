<?php

use yii\db\Migration;

class m170419_063638_create_post_like extends Migration
{
    public function up()
    {
        $this->createTable('mls_post_like', [
            'id' => $this->bigPrimaryKey(),
            'user_id'=>$this->bigInteger()->notNull(),
            'model_id'=>$this->bigInteger()->notNull(),
            'model' => $this->string(75)->notNull(),
            'like_count' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_post_like-user_id',
            'mls_post_like',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_post_like-user_id',
            'mls_post_like',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_post_like');
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
