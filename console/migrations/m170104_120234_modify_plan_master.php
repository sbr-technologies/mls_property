<?php

use yii\db\Migration;
use yii\db\Schema;
class m170104_120234_modify_plan_master extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%plan_master}}', 'type');
        $this->addColumn('{{%plan_master}}', 'service_category_id', $this->bigInteger()->notNull()->after('id'));
        
        // creates index for column `post_id`
        $this->createIndex(
            'idx-plan_master-service_category_id',
            '{{%plan_master}}',
            'service_category_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-plan_master-service_category_id',
            '{{%plan_master}}',
            'service_category_id',
            '{{%service_category}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        echo "m170104_120234_modify_plan_master cannot be reverted.\n";

        return false;
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
