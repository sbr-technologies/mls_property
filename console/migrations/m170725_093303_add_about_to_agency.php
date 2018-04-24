<?php

use yii\db\Migration;

class m170725_093303_add_about_to_agency extends Migration
{
    use console\helpers\MySchemaBuilderTrait;
    public function safeUp()
    {
        $this->addColumn('{{%agency}}', 'about', $this->longText()->null()->after('web_address'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%agency}}', 'about');
    }

    
}
