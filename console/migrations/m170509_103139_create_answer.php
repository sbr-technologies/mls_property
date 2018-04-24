<?php

use yii\db\Migration;

class m170509_103139_create_answer extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function up(){
        $this->createTable('mls_answer', [
            'id' => $this->bigPrimaryKey(),
            'question_id' => $this->bigInteger()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'title' => $this->string(255)->null(),
            'description' => $this->longText()->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_answer-user_id',
            'mls_answer',
            'user_id'
        );

        // add foreign key for table `mls_user`
        $this->addForeignKey(
            'fk-mls_answer-user_id',
            'mls_answer',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
        
        // creates index for column `question_id`
        $this->createIndex(
            'idx-mls_answer-question_id',
            'mls_answer',
            'question_id'
        );

        // add foreign key for table `mls_question`
        $this->addForeignKey(
            'fk-mls_answer-question_id',
            'mls_answer',
            'question_id',
            'mls_question',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_answer');
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
