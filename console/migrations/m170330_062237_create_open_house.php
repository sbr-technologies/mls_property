<?php

use yii\db\Migration;

class m170330_062237_create_open_house extends Migration
{
    public function up()
    {
        $this->createTable('mls_open_house', [
            'id' => $this->bigPrimaryKey(),
            'property_id'=> $this->bigInteger()->notNull(),
            'date' => $this->date()->notNull(),
            'start_time' => $this->string(35)->null(),
            'end_time' => $this->string(35)->null(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_open_house-property_id',
            'mls_open_house',
            'property_id'
        );

        // add foreign key for table `mls_open_house`
        $this->addForeignKey(
            'fk-mls_open_house-property_id',
            'mls_open_house',
            'property_id',
            'mls_property',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_open_house');
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
