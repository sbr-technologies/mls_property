<?php

use yii\db\Migration;

class m161226_112333_create_advertisement_banner extends Migration
{
    public function up()
    {
        $this->createTable('{{%advertisement_banner}}', [
            'id' => $this->bigPrimaryKey(),
            'ad_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(100)->null(),
            'description' => $this->text()->null(),
            'text_color' => $this->string(10)->null(),
            'sort_order' => $this->integer()->notNull()->defaultValue(999),
            'status' => $this->string(15)->notNull(),
        ]);
        
        // creates index for column `ad_id`
        $this->createIndex(
            'idx-advertisement_banner-ad_id',
            '{{%advertisement_banner}}',
            'ad_id'
        );

        // add foreign key for table `mls_advertisement`
        $this->addForeignKey(
            'fk-advertisement_banner-ad_id',
            'mls_advertisement_banner',
            'ad_id',
            '{{%advertisement}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%advertisement_banner}}');
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
