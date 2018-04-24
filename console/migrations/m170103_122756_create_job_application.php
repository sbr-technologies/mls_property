<?php

use yii\db\Migration;

class m170103_122756_create_job_application extends Migration
{
    public function safeUp()
    {
        $this->createTable('mls_job_application', [
            'id' => $this->bigPrimaryKey(),
            'first_name' => $this->string(128)->notNull(),
            'middle_name' => $this->string(128)->null(),
            'last_name' => $this->string(128)->notNull(),
            'email'=>$this->string()->notNull(),
            'calling_code'=>$this->string(15)->null(),
            'phone_number'=>$this->string(20)->null(),
            'gender'=>$this->smallInteger(2)->null(),
            'dob'=>$this->date()->null(),
            'zip_code'=>$this->string(15)->null(),
            'ip_address'=>$this->string(35)->notNull(),
            'status' => $this->string(15)->null(),
            'created_by'=>$this->bigInteger()->null(),
            'updated_by'=>$this->bigInteger()->null(),
            'created_at'=>$this->integer()->notNull(),
            'updated_at'=>$this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
       $this->dropTable('mls_job_application');
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
