<?php

use yii\db\Migration;

class m170728_120240_create_team_agency_mapping extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%team_agency_mapping}}', [
            'id' => $this->bigPrimaryKey(),
            'team_id' => $this->bigInteger()->notNull(),
            'agency_id' => $this->bigInteger()->notNull()
        ]);
        
        // creates index for column `agency_id`
        $this->createIndex(
            'idx-team_agency_mapping-agency_id',
            '{{%team_agency_mapping}}',
            'agency_id'
        );

        // add foreign key for table `agency`
        $this->addForeignKey(
            'fk-team_agency_mapping-agency_id',
            '{{%team_agency_mapping}}',
            'agency_id',
            '{{%agency}}',
            'id',
            'CASCADE'
        );
        
        // creates index for column `team_id`
        $this->createIndex(
            'idx-team_agency_mapping-team_id',
            '{{%team_agency_mapping}}',
            'team_id'
        );

        // add foreign key for table `team`
        $this->addForeignKey(
            'fk-team_agency_mapping-team_id',
            '{{%team_agency_mapping}}',
            'team_id',
            '{{%team}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
         $this->dropTable('{{%team_agency_mapping}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170728_120240_create_team_agency_mapping cannot be reverted.\n";

        return false;
    }
    */
}
