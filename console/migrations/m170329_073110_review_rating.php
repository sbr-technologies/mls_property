<?php

use yii\db\Migration;

class m170329_073110_review_rating extends Migration
{
    public function up()
    {
        $this->createTable('mls_review_rating', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull()->comment('Review and Rating is given by this user'),
            'model' => $this->string(100)->notNull(),
            'model_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(128)->null(),
            'description' => $this->text()->null(),
            'rating' => $this->smallInteger()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_review_rating-user_id',
            'mls_review_rating',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_review_rating-user_id',
            'mls_review_rating',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_review_rating');
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
