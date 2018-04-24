<?php

use yii\db\Migration;

class m161226_124056_create_static_page extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up()
    {
        $this->createTable('mls_static_page', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull(),
            'content' => $this->longText()->notNull(),
            'slug' => $this->string(150)->notNull(),
            'meta_title' => $this->string()->null(),
            'meta_keywords' => $this->text()->null(),
            'meta_description' => $this->text()->null(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->batchInsert('{{%static_page}}', ['name', 'content', 'slug','meta_title','meta_keywords','meta_description','status','created_at','updated_at'], [
            ['Home', 'home', 'home','home_title','Home meta Keyword','description','active',strtotime('now'),strtotime('now')],
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_static_page');
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
