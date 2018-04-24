<?php

use yii\db\Migration;

class m170529_090558_add_service_category_id_to_subscription extends Migration
{
    public function up()
    {
        $this->addColumn('{{%subscription}}', 'service_category_id', $this->bigInteger()->notNull()->after('plan_id'));
        
        $this->createIndex(
            'idx-subscription-service_category_id',
            '{{%subscription}}',
            'service_category_id'
        );

        // add foreign key for table `mls_hotel`
        $this->addForeignKey(
            'fk-subscription-service_category_id',
            '{{%subscription}}',
            'service_category_id',
            '{{%service_category}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-subscription-service_category_id', '{{%subscription}}');
        $this->dropColumn('{{%subscription}}', 'service_category_id');
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
