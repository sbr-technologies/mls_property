<?php

use yii\db\Migration;

class m161226_102143_create_contact_form_db extends Migration
{
    public function up()
    {
        $this->createTable('mls_contact_form_db', [
            'id' => $this->bigPrimaryKey(),
            'salutation' => $this->string(20)->null(),
            'full_name' => $this->string(255)->notNull(),
            'email' => $this->string(120)->notNull(),
            'subject' => $this->string()->notNull(),
            'message' => $this->text()->notNull(),
            'status' => $this->smallInteger(2)->notNull()->defaultValue(0),
            'sent_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            
        ]);
    }

    public function down()
    {
        $this->dropTable('mls_contact_form_db');
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
