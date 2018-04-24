<?php

use yii\db\Migration;

class m170516_083218_modification_on_property_request extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function safeUp(){
        $this->dropForeignKey('fk-mls_property_request-property_id', '{{%property_request}}');
        $this->dropColumn('{{%property_request}}', 'property_id');
        $this->dropColumn('{{%property_request}}', 'created_by');
        $this->dropColumn('{{%property_request}}', 'updated_by');
        $this->addColumn('{{%property_request}}', 'property_category_id', $this->bigInteger()->notNull()->after('user_id'));
        $this->addColumn('{{%property_request}}', 'property_type_id', $this->bigInteger()->notNull()->after('property_category_id'));
        $this->addColumn('{{%property_request}}', 'budget', $this->string(35)->notNull()->after('property_type_id'));
        $this->addColumn('{{%property_request}}', 'no_of_bed_room', $this->integer()->notNull()->after('budget'));
        $this->addColumn('{{%property_request}}', 'state', $this->string(75)->notNull()->after('no_of_bed_room'));
        $this->addColumn('{{%property_request}}', 'locality', $this->string(255)->null()->after('state'));
        $this->addColumn('{{%property_request}}', 'comment', $this->longText()->null()->after('locality'));
        
        $this->createIndex(
            'idx-property_request-property_category_id',
            '{{%property_request}}',
            'property_category_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-property_request-property_category_id',
            '{{%property_request}}',
            'property_category_id',
            '{{%property_category}}',
            'id',
            'CASCADE'
        );
        
        $this->createIndex(
            'idx-property_request-property_type_id',
            '{{%property_request}}',
            'property_type_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-property_request-property_type_id',
            '{{%property_request}}',
            'property_type_id',
            '{{%property_type}}',
            'id',
            'CASCADE'
        );
        
    }

    public function down()
    {
        
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
