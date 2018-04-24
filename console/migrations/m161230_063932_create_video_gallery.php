<?php

use yii\db\Migration;

class m161230_063932_create_video_gallery extends Migration
{
    public function up()
    {
        $this->createTable('mls_video_gallery', [
            'id' => $this->bigPrimaryKey(),
            'model' => $this->string(100)->null(),
            'model_id' => $this->bigInteger()->null(),
            'title' => $this->string(128)->notNull(),
            'description' => $this->text()->null(),
            'video_file_name' => $this->string()->null(),
            'video_file_extension' => $this->string(5)->null(),
            'original_file_name' => $this->string()->null(),
            'youtube_video_code' => $this->string(75)->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_video_gallery');
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
