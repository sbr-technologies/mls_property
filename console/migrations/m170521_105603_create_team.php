<?php

use yii\db\Migration;

class m170521_105603_create_team extends Migration
{
    public function up()
    {
        $this->createTable('{{%team}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull(),
            'teamID' => $this->string()->null(),
            'created_by' => $this->bigInteger()->null(),
            'updated_by' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('pending')
        ]);
        
        $this->addColumn('{{%user}}', 'team_id', $this->bigInteger()->null()->after('agency_id'));
        // creates index for column `team_id`
        $this->createIndex(
            'idx-user-team_id',
            '{{%user}}',
            'team_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-user-team_id',
            '{{%user}}',
            'team_id',
            '{{%team}}',
            'id',
            'SET NULL'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-user-team_id', '{{%user}}');
        $this->dropColumn('{{%user}}', 'team_id');
        $this->dropTable('{{%team}}');
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
