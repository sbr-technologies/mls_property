<?php

use yii\db\Migration;

class m170424_120810_modify_details_to_rental extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%rental}}', 'size_range');
        $this->addColumn('{{%rental}}', 'size', $this->integer()->notNull()->defaultValue(0)->after('metric_type_id'));
        $this->addColumn('{{%rental}}', 'size_max', $this->integer()->null()->after('size'));
        
        $this->dropColumn('{{%rental}}', 'lot_area_range');
        $this->addColumn('{{%rental}}', 'lot_area', $this->integer()->notNull()->defaultValue(0)->after('metric_type_id'));
        $this->addColumn('{{%rental}}', 'lot_area_max', $this->integer()->null()->after('lot_area'));
        
        $this->dropColumn('{{%rental}}', 'room_range');
        $this->addColumn('{{%rental}}', 'no_of_room', $this->integer()->notNull()->defaultValue(0)->after('metric_type_id'));
        $this->addColumn('{{%rental}}', 'no_of_room_max', $this->integer()->null()->after('no_of_room'));
        
        $this->dropColumn('{{%rental}}', 'balcony_range');
        $this->addColumn('{{%rental}}', 'no_of_balcony', $this->integer()->notNull()->defaultValue(0)->after('metric_type_id'));
        $this->addColumn('{{%rental}}', 'no_of_balcony_max', $this->integer()->null()->after('no_of_balcony'));
        
        $this->dropColumn('{{%rental}}', 'bathroom_range');
        $this->addColumn('{{%rental}}', 'no_of_bathroom', $this->integer()->notNull()->defaultValue(0)->after('metric_type_id'));
        $this->addColumn('{{%rental}}', 'no_of_bathroom_max', $this->integer()->null()->after('no_of_bathroom'));
        
        $this->addColumn('{{%rental}}', 'price_max', $this->integer()->null()->after('price'));
    }

    public function down()
    {
        echo "m170424_120810_modify_details_to_rental cannot be reverted.\n";

        return false;
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
