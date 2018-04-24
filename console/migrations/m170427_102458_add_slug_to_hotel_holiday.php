<?php

use yii\db\Migration;

class m170427_102458_add_slug_to_hotel_holiday extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%hotel}}', 'slug', $this->string(255)->notNull()->after('name'));
        $this->addColumn('{{%holiday_package}}', 'slug', $this->string(255)->notNull()->after('name'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%hotel}}', 'slug');
        $this->dropColumn('{{%holiday_package}}', 'slug');
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
