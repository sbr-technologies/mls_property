<?php

use yii\db\Migration;

class m170120_090638_create_banner_type extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%banner_type}}', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'text_color' => $this->string(10)->null(),
            'status' => $this->string(15)->null(),
        ]);
        
        $this->addColumn('{{%banner}}', 'type_id', $this->bigInteger()->notNull()->after('id'));
        // creates index for column `post_id`
        $this->createIndex(
            'idx-banner-type_id',
            '{{%banner}}',
            'type_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-banner-type_id',
            '{{%banner}}',
            'type_id',
            '{{%banner_type}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-banner-type_id', '{{%banner}}');
        $this->dropColumn('{{%banner}}', 'type_id');
        $this->dropTable('{{%banner_type}}');
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
