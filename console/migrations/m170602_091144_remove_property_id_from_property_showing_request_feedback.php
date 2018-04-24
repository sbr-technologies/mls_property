<?php

use yii\db\Migration;

class m170602_091144_remove_property_id_from_property_showing_request_feedback extends Migration
{
    public function up()
    {
       $this->dropForeignKey('fk-mls_property_showing_request_feedback-property_id', '{{%property_showing_request_feedback}}');
        $this->dropColumn('{{%property_showing_request_feedback}}', 'property_id');
        $this->addColumn('{{%property_showing_request_feedback}}', 'model_id', $this->bigInteger()->notNull()->after('requested_to'));
        $this->addColumn('{{%property_showing_request_feedback}}', 'model', $this->string(100)->notNull()->after('model_id'));
    }

    public function down()
    {
        $this->dropColumn('{{%property_showing_request_feedback}}', 'model_id');
        $this->dropColumn('{{%property_showing_request_feedback}}', 'model');
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
