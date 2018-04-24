<?php

use yii\db\Migration;

class m170202_125340_create_meta_tag extends Migration
{
    public function up()
    {
        $this->createTable('{{%meta_tag}}', [
            'id' => $this->bigPrimaryKey(),
            'model' => $this->string(75)->notNull(),
            'model_id' => $this->integer()->notNull(),
            'page_title' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),
            'keywords' => $this->text()->null(),
        ]);
        
        
    }

    public function down()
    {
        $this->dropTable('{{%meta_tag}}');
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
