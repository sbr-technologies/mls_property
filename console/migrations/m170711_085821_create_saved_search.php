<?php

use yii\db\Migration;

class m170711_085821_create_saved_search extends Migration
{
    public function up()
    {
        $this->createTable('{{%saved_search}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'type' => $this->string()->null()->comment('Property / Agent / Agency / Team'),
            'search_string' => $this->text()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('active'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%saved_search}}');
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
