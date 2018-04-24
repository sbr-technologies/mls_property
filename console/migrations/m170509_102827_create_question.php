<?php

use yii\db\Migration;

class m170509_102827_create_question extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up(){
        $this->createTable('mls_question', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->longText()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_question-user_id',
            'mls_question',
            'user_id'
        );

        // add foreign key for table `mls_holiday_package`
        $this->addForeignKey(
            'fk-mls_question-user_id',
            'mls_question',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_question');
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
