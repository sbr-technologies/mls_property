<?php

use yii\db\Migration;

class m170408_084533_create_user_favorite extends Migration
{
    public function up()
    {
        $this->createTable('mls_user_favorite', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'model' => $this->string(100)->null(),
            'model_id' => $this->bigInteger()->null(),
        ]);
        // creates index for column `property_id`
        $this->createIndex(
            'idx-mls_user_favorite-user_id',
            'mls_user_favorite',
            'user_id'
        );

        // add foreign key for table `mls_property_feature`
        $this->addForeignKey(
            'fk-mls_user_favorite-user_id',
            'mls_user_favorite',
            'user_id',
            'mls_user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('mls_user_favorite');
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
