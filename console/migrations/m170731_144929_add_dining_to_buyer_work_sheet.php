<?php

use yii\db\Migration;

class m170731_144929_add_dining_to_buyer_work_sheet extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%buyer_work_sheet}}', 'dining', $this->string(15)->null()->after('living'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%buyer_work_sheet}}', 'dining');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170731_144929_add_dining_to_buyer_work_sheet cannot be reverted.\n";

        return false;
    }
    */
}
