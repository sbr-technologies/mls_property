<?php

use yii\db\Migration;

class m170509_141615_create_recommend extends Migration
{
    public function up(){
        $this->createTable('mls_recommend', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'recommend_id' => $this->bigInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-mls_recommend-user_id',
            'mls_recommend',
            'user_id'
        );

        // add foreign key for table `mls_holiday_package`
        $this->addForeignKey(
            'fk-mls_recommend-user_id',
            'mls_recommend',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down(){
        $this->dropTable('mls_recommend');
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
