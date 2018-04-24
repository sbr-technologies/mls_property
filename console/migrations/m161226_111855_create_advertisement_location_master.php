<?php

use yii\db\Migration;

class m161226_111855_create_advertisement_location_master extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%advertisement_location_master}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(100)->null(),
            'description' => $this->text()->null(),
            'page' => $this->string(128)->notNull(),
            'section' => $this->string(128)->null(),
            'status' => $this->string(15)->notNull(),
        ]);
        
        $this->batchInsert('{{%advertisement_location_master}}', ['title', 'description', 'page', 'section', 'status'], [
            ['Homa page top', 'This will appear on top of home page', 'home', 'top', 'active'],
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_advertisement_location_master');
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
