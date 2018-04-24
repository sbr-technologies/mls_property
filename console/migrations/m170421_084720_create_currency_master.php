<?php

use yii\db\Migration;

class m170421_084720_create_currency_master extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%currency_master}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(100)->notNull(),
            'code' => $this->string(3)->notNull(),
            'symbol' => $this->string(2)->null(),
            'ex_rate' => $this->decimal(5,2)->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
        $this->batchInsert('{{%currency_master}}', ['name', 'code', 'symbol', 'ex_rate', 'status'], [
            ['Doller', 'USD', '$', 1, 'active'],
        ]);
        
        $this->dropColumn('{{%property}}', 'currency');
        $this->dropColumn('{{%rental}}', 'currency');
        
        $this->addColumn( '{{%property}}', 'currency_id', $this->bigInteger()->null()->after('status_of_electricity'));
        $this->addColumn( '{{%rental}}', 'currency_id', $this->bigInteger()->null()->after('status_of_electricity'));
    }

    public function down()
    {
       $this->dropTable('{{%currency_master}}');
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
