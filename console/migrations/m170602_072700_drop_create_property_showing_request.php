<?php

use yii\db\Migration;

class m170602_072700_drop_create_property_showing_request extends Migration
{
    public function up()
    {
        //$this->dropForeignKey('idx-mls_property_showing_request-property_id', '{{%property_showing_request}}');
        $this->dropColumn('{{%property_showing_request}}', 'property_id');
        $this->dropColumn('{{%property_showing_request}}', 'reply');
        $this->dropColumn('{{%property_showing_request}}', 'requested_by');
        $this->dropColumn('{{%property_showing_request}}', 'looking_to');
        $this->dropColumn('{{%property_showing_request}}', 'type');
        $this->dropColumn('{{%property_showing_request}}', 'no_bedroom');
        $this->dropColumn('{{%property_showing_request}}', 'budget');
        $this->dropColumn('{{%property_showing_request}}', 'state');
        $this->dropColumn('{{%property_showing_request}}', 'locality');
        $this->addColumn('{{%property_showing_request}}', 'model_id', $this->bigInteger()->notNull()->after('user_id'));
        $this->addColumn('{{%property_showing_request}}', 'model', $this->string(100)->notNull()->after('model_id'));
    }

    public function down()
    {
        echo 'Not able to revert';
        return false;
    }
}
