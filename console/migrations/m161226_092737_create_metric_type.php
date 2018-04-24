<?php

use yii\db\Migration;

class m161226_092737_create_metric_type extends Migration
{
    public function up()
    {
        $this->createTable('mls_metric_type', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->string(50)->notNull(),
            'name' => $this->string(100)->notNull(),
            'factor' => $this->decimal(4,2)->notNull(),
            'status' => $this->string(15)->notNull(),
        ]);
        $this->batchInsert('{{%metric_type}}', ['type', 'name', 'factor','status'], [
            ['Length', 'Meter', 1,'active'],
            ['Area', 'Square Feet', 3,'active'],  
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_metric_type');
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
