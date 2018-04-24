<?php

use yii\db\Migration;

class m161226_093420_create_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('mls_user', [
            'id' => $this->bigPrimaryKey(),
            'mls_id' => $this->string(50)->null(),
            'profile_id' => $this->bigInteger()->notNull(),
            'salutation' => $this->string(10)->null(),
            'first_name' => $this->string(128)->notNull(),
            'middle_name' => $this->string(128)->null(),
            'last_name' => $this->string(128)->notNull(),
            'username' => $this->string()->null(),
            'short_name' => $this->string(50)->null(),
            'lat' => $this->double(7)->null(),
            'lng' => $this->double(7)->null(),
            'auth_key' => $this->string()->null(),
            'password_hash' => $this->string()->null(),
            'password_reset_token'=>$this->string()->null(),
            'email'=>$this->string()->notNull(),
            'phone_number'=>$this->string(20)->null(),
            'calling_code'=>$this->string(15)->null(),
            'gender'=>$this->smallInteger(2)->null(),
            'dob'=>$this->date()->null(),
            'zip_code'=>$this->string(15)->null(),
            'tagline'=>$this->string(100)->null(),
            'profile_image_file_name'=>$this->string(128)->null(),
            'profile_image_extension'=>$this->string(5)->null(),
            'cover_photo' => $this->string(255)->null(),
            'email_activation_key'=>$this->string(35)->null(),
            'otp'=>$this->string(6)->null(),
            'phone_verified'=>$this->smallInteger(1)->notNull()->defaultValue(0),
            'email_verified'=>$this->smallInteger(1)->notNull()->defaultValue(0),
            'email_activation_sent'=>$this->integer()->null(),
            'avg_rating'=>$this->decimal(3,2)->null(),
            'total_reviews'=>$this->integer()->notNull()->defaultValue(0),
            'ip_address'=>$this->string(35)->notNull(),
            'membership_id'=>$this->smallInteger()->null(),
            'address1'=>$this->string(128)->null(),
            'address2'=>$this->string(128)->null(),
            'city'=>$this->string(75)->null(),
            'state' => $this->string(75)->null(),
            'country'=>$this->string(75)->null(),
            'social_id'=>$this->string(100)->null(),
            'social_type'=>$this->string(50)->null(),
            'slug'=>$this->string(25)->null(),
            'timezone'=>$this->string(60)->null(),
            'is_login_blocked'=>$this->smallInteger(4)->null(),
            'login_blocked_at'=>$this->dateTime()->null(),
            'failed_login_cnt'=>$this->integer()->notNull()->defaultValue(0),
            'status' => $this->string(15)->null(),
            'intrest_in' => $this->string(75)->null(),
            'about' => $this->text()->null(),
            'exp_year' => $this->string(10)->null(),
            'specialization' => $this->text()->null(),
            'area_served' => $this->text()->null(),
            'brokerage' => $this->text()->null(),
            'price_range' => $this->string(35)->null(),
            'created_by'=>$this->bigInteger()->null(),
            'updated_by'=>$this->bigInteger()->null(),
            'created_at'=>$this->integer()->notNull(),
            'updated_at'=>$this->integer()->notNull(),
        ]);
         
        
        // creates index for column `profile_id`
        $this->createIndex(
            'idx-mls_user-profile_id',
            'mls_user',
            'profile_id'
        );

        // add foreign key for table `mls_profile`
        $this->addForeignKey(
            'fk-mls_user-profile_id',
            'mls_user',
            'profile_id',
            'mls_profile',
            'id',
            'CASCADE'
        );
        
        
        $this->insert('{{%user}}', [
            'profile_id' => 1,
            'username' => 'superadmin',
            'password_hash' => '$2y$13$llspypeYPnRsGxwyswfooecpJfqcr5v5elpBiYRW17BVJjMedd.Be',//ZCcADBM8YTB5htbc
            'email' => 'admin@mls.com',
            'first_name' => 'Santinath',
            'last_name' => 'Roy',
            'ip_address' => '127.0.0.1',
            'created_at' => strtotime('now'),
            'updated_at' => strtotime('now'),
            'status' => 'active'
        ]);
        $this->insert('{{%user}}', [
            'profile_id' => 2,
            'username' => 'admin',
            'password_hash' => '$2y$13$llspypeYPnRsGxwyswfooecpJfqcr5v5elpBiYRW17BVJjMedd.Be',//ZCcADBM8YTB5htbc
            'email' => 'admin@mls.com',
            'first_name' => 'Rashmi R',
            'last_name' => 'Das',
            'ip_address' => '127.0.0.1',
            'created_at' => strtotime('now'),
            'updated_at' => strtotime('now'),
            'status' => 'active'
        ]);
    }

    public function safeDown()
    {
       $this->dropTable('mls_user');
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
