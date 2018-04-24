<?php

use yii\db\Migration;

class m170103_051214_create_newsletter_template_var_master extends Migration
{
    public function up()
    {
        $this->createTable('mls_newsletter_template_var_master', [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string(50)->notNull(),
            'variable' => $this->string(50)->null(),
            'status' => $this->string(15)->null(),
        ]);
        
        $this->batchInsert('{{%newsletter_template_var_master}}', ['title', 'variable', 'status'], [
            ['User full name', '{{%fullName%}}', 'active'],
            ['Site url', '{{%siteUrl%}}', 'active'],
            ['User Email', '{{%userEmail%}}', 'active'],
            ['Support Email', '{{%supportEmail%}}', 'active']
        ]);
    }
    

    public function down()
    {
        $this->dropTable('mls_newsletter_template_var_master');
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
