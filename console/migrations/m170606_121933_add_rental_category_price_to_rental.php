<?php

use yii\db\Migration;

class m170606_121933_add_rental_category_price_to_rental extends Migration
{
    public function up(){
        $this->addColumn('{{%rental}}', 'rental_category', $this->string(75)->notNull()->after('electricity_type_ids'));
        $this->addColumn('{{%rental}}', 'price_for', $this->string(35)->null()->after('price_max'));
        $this->addColumn('{{%rental}}', 'service_fee', $this->integer()->null()->after('price_for'));
        $this->addColumn('{{%rental}}', 'service_fee_for', $this->string(35)->null()->after('service_fee'));
        $this->addColumn('{{%rental}}', 'other_fee', $this->integer()->null()->after('service_fee_for'));
        $this->addColumn('{{%rental}}', 'other_fee_for', $this->string(35)->null()->after('other_fee'));
    }

    public function down()
    {
        $this->dropColumn('{{%rental}}', 'rental_category');
        $this->dropColumn('{{%rental}}', 'price_for');
        $this->dropColumn('{{%rental}}', 'service_fee');
        $this->dropColumn('{{%rental}}', 'service_fee_for');
        $this->dropColumn('{{%rental}}', 'other_fee');
        $this->dropColumn('{{%rental}}', 'other_fee_for');
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
