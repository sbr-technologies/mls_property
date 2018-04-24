<?php

use yii\db\Migration;

class m161226_113509_create_photo_gallery extends Migration
{
    public function up()
    {
        $this->createTable('mls_photo_gallery', [
            'id' => $this->bigPrimaryKey(),
            'model' => $this->string(100)->notNull(),
            'model_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(128)->notNull(),
            'description' => $this->text()->null(),
            'image_file_name' => $this->string()->notNull(),
            'image_file_extension' => $this->string(5)->notNull(),
            'original_file_name' => $this->string()->notNull(),
            'size' => $this->integer()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_photo_gallery');
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
