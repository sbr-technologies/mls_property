<?php

use yii\db\Migration;

class m161226_100704_create_property_type extends Migration
{
    public function up()
    {
        $this->createTable('mls_property_type', [
            'id' => $this->bigPrimaryKey(),
            'property_category_id'=> $this->bigInteger()->notNull(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'status' => $this->string(15)->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        // creates index for column `property_category_id`
        $this->createIndex(
            'idx-mls_property_type-property_category_id',
            'mls_property_type',
            'property_category_id'
        );

        // add foreign key for table `mls_profile`
        $this->addForeignKey(
            'fk-mls_property_type-property_category_id',
            'mls_property_type',
            'property_category_id',
            'mls_property_category',
            'id',
            'CASCADE'
        );
        $this->batchInsert('{{%property_type}}', ['property_category_id', 'title','description','status','created_by','updated_by', 'created_at', 'updated_at'], [
            [1,'Room share', '','active','','', strtotime('now'), strtotime('now')],
            [1,'Holiday Apartment', '','active','','', strtotime('now'), strtotime('now')],
            [1,'Luxury Apartment', '','active','','', strtotime('now'), strtotime('now')],
            [1,'Short Term vacations', '','active','','', strtotime('now'), strtotime('now')],
            [1,'Long Term Vacations', '','active','','', strtotime('now'), strtotime('now')],
            [2,'Pre construction', '','active','','', strtotime('now'), strtotime('now')],
            [2,'Luxury Homes', '','active','','', strtotime('now'), strtotime('now')],
            [2,'New Development', '','active','','', strtotime('now'), strtotime('now')],
            [2,'Terraces', '','active','','', strtotime('now'), strtotime('now')],
            [2,'Residential Website Content', '','active','','', strtotime('now'), strtotime('now')],
            [2,'Commercial', '','active','','', strtotime('now'), strtotime('now')],
            [2,'Condominium', '','active','','', strtotime('now'), strtotime('now')],
            [2,'Single Property', '','active','','', strtotime('now'), strtotime('now')],
            
        ]);
    }
    
    
    public function down()
    {
        $this->dropTable('mls_property_type');
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
