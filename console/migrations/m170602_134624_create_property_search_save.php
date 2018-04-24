<?php

use yii\db\Migration;

class m170602_134624_create_property_search_save extends Migration
{
    public function up()
    {
        $this->createTable('{{%property_search_save}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'address' => $this->string(100)->null(),
            'city' => $this->string(100)->null(),
            'state' => $this->string(50)->null(),
            'zip_code' => $this->string(50)->null(),
            'bedroom' => $this->integer()->null(),
            'bathroom' => $this->integer()->null(),
            'currency_id' => $this->bigInteger()->null(),
            'min_price' => $this->integer()->null(),
            'max_price' => $this->integer()->null(),
            'property_type_id' => $this->bigInteger()->null(),
            'type' => $this->string(10)->null()->comment('Property/Rental'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        $this->createIndex(
            'idx-property_search_save-user_id',
            '{{%property_search_save}}',
            'user_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-property_search_save-user_id',
            '{{%property_search_save}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        
        $this->createIndex(
            'idx-property_search_save-property_type_id',
            '{{%property_search_save}}',
            'property_type_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-property_search_save-property_type_id',
            '{{%property_search_save}}',
            'property_type_id',
            '{{%property_type}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%property_search_save}}');
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
