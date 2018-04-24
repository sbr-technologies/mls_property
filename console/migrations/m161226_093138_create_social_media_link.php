<?php

use yii\db\Migration;

class m161226_093138_create_social_media_link extends Migration
{
    public function up()
    {
        $this->createTable('{{%social_media_link}}', [
            'id' => $this->bigPrimaryKey(),
            'model' => $this->string(50)->notNull(),
            'model_id' => $this->bigInteger()->notNull(),
            'name' => $this->string(100)->notNull(),
            'url' => $this->string()->notNull(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%social_media_link}}');
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
