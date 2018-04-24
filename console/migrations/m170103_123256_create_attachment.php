<?php

use yii\db\Migration;

class m170103_123256_create_attachment extends Migration
{
    public function up()
    {
        $this->createTable('mls_attachment', [
            'id' => $this->bigPrimaryKey(),
            'model' => $this->string(100)->notNull(),
            'model_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(128)->notNull(),
            'description' => $this->text()->null(),
            'file_name' => $this->string()->notNull(),
            'file_extension' => $this->string(5)->notNull(),
            'original_file_name' => $this->string()->notNull(),
            'size' => $this->integer()->notNull(),
            'type' => $this->string(50)->notNull()->comment("MIME-type of the uploaded file"),
            'status' => $this->string(15)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_attachment');
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
