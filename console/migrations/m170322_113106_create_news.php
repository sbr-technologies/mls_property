<?php

use yii\db\Migration;

class m170322_113106_create_news extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_news', [
            'id' => $this->bigPrimaryKey(),
            'news_category_id'=> $this->bigInteger()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->longText()->notNull(),
            'slug' => $this->string()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        // creates index for column `new_category_id`
        $this->createIndex(
            'idx-mls_news-news_category_id',
            'mls_news',
            'news_category_id'
        );

        // add foreign key for table `mls_news_category`
        $this->addForeignKey(
            'fk-mls_news-news_category_id',
            'mls_news',
            'news_category_id',
            'mls_news_category',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_news');
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
