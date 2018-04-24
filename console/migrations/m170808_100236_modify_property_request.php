<?php

use yii\db\Migration;

class m170808_100236_modify_property_request extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function safeUp()
    {
        $this->dropTable('mls_property_request');
        $this->createTable('mls_property_request', [
            'id'                => $this->bigPrimaryKey(),
            'referenceId'       => $this->string(100)->null(),
            'user_id'           => $this->bigInteger()->notNull(),
            'property_type_id'  => $this->bigInteger()->notNull(),
            'property_category' => $this->string(35)->notNull(),
            'budget_from'       => $this->integer()->notNull(),
            'budget_to'         => $this->integer()->null(),
            'no_of_bed_room'    => $this->integer()->notNull(),
            'state'             => $this->string(75)->notNull(),
            'area'              => $this->string(125)->null(),
            'locality'          => $this->string(255)->null(),
            'schedule'          => $this->date()->notNull(),
            'comment'           => $this->longText()->null(),
            'status'            => $this->string()->notNull(),
            'created_at'        => $this->integer()->notNull(),
            'updated_at'        => $this->integer()->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_property_request-user_id',
            'mls_property_request',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_property_request-user_id',
            'mls_property_request',
            'user_id',
            'mls_user',
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

    public function safeDown()
    {
        $this->dropTable('mls_property_request');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170808_100236_modify_property_request cannot be reverted.\n";

        return false;
    }
    */
}
