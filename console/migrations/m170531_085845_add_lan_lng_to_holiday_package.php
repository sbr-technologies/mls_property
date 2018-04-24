<?php

use yii\db\Migration;

class m170531_085845_add_lan_lng_to_holiday_package extends Migration
{
    public function up()
    {
        $this->addColumn('{{%holiday_package}}', 'currency_id', $this->bigInteger()->notNull()->after('description'));
        $this->addColumn('{{%holiday_package}}', 'source_lat', $this->double(10, 7)->null()->after('source_country'));
        $this->addColumn('{{%holiday_package}}', 'source_lng', $this->double(10, 7)->null()->after('source_lat'));
        $this->addColumn('{{%holiday_package}}', 'destination_lat', $this->double(10, 7)->null()->after('destination_country'));
        $this->addColumn('{{%holiday_package}}', 'destination_lng', $this->double(10, 7)->null()->after('destination_lat'));
        
        $this->createIndex(
            'idx-holiday_package-currency_id',
            '{{%holiday_package}}',
            'currency_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-holiday_package-currency_id',
            '{{%holiday_package}}',
            'currency_id',
            '{{%currency_master}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('idx-holiday_package-currency_id', '{{%holiday_package}}');
        $this->dropColumn('{{%holiday_package}}', 'currency_id');
        $this->dropColumn('{{%holiday_package}}', 'source_lat');
        $this->dropColumn('{{%holiday_package}}', 'source_lng');
        $this->dropColumn('{{%holiday_package}}', 'destination_lat');
        $this->dropColumn('{{%holiday_package}}', 'destination_lng');
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
