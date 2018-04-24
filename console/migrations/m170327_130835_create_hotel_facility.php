<?php

use yii\db\Migration;

class m170327_130835_create_hotel_facility extends Migration
{
    public function up()
    {
        $this->createTable('{{%hotel_facility}}', [
            'id' => $this->bigPrimaryKey(),
            'hotel_id'=> $this->bigInteger()->notNull(),
            'title' => $this->string(75)->notNull(),
        ]);
        // creates index for column `hotel_id`
        $this->createIndex(
            'idx-hotel_facility-hotel_id',
            '{{%hotel_facility}}',
            'hotel_id'
        );

        // add foreign key for table `hotel`
        $this->addForeignKey(
            'fk-hotel_facility-hotel_id',
            '{{%hotel_facility}}',
            'hotel_id',
            '{{%hotel}}',
            'id',
            'CASCADE'
        );
        
        
    }

    public function down()
    {
        $this->dropTable('{{%hotel_facility}}');
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
