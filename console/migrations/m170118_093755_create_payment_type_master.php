<?php

use yii\db\Migration;

class m170118_093755_create_payment_type_master extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%payment_type_master}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull(),
            'code' => $this->string(15)->null(),
            'status' => $this->string(15)->notNull(),
        ]);
        $this->batchInsert('{{%payment_type_master}}', ['title', 'description', 'code','status'], [
            ['Subscription', '', 'subscription','active'],
            ['Deal', '', 'deal','active'],  
        ]);
        $this->addColumn('{{%user}}', 'payment_type_id', $this->bigInteger()->null()->after('agency_id'));
        
        // creates index for column `post_id`
        $this->createIndex(
            'idx-user-payment_type_id',
            '{{%user}}',
            'payment_type_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-user-payment_type_id',
            '{{%user}}',
            'payment_type_id',
            '{{%payment_type_master}}',
            'id',
            'CASCADE'
        );
        
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-user-payment_type_id',
            'post'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-user-payment_type_id',
            'post'
        );
        $this->dropTable('{{%payment_type_master}}');
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
