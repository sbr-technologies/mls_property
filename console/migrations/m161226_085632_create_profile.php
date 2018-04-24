<?php

use yii\db\Migration;

class m161226_085632_create_profile extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('mls_profile', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'no_of_member' => $this->integer()->notNull()->defaultValue(0),
        ]);
        
        $this->batchInsert('{{%profile}}', ['type', 'title'], [
            ['superadmin', 'Super Admin'],
            ['admin', 'Admin'],
            ['buyer', 'Buyer'],
            ['seller', 'Seller'],
            ['agent', 'Agent'],
            ['hotel', 'Hotel']
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('mls_profile');
    }

}
