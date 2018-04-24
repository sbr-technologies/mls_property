<?php

use yii\db\Migration;

class m170329_072018_average_rating_to_related_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%property}}', 'avg_rating', $this->decimal(3,2)->null()->after('watermark_image'));
        $this->addColumn('{{%property}}', 'total_reviews', $this->integer()->notNull()->defaultValue(0)->after('avg_rating'));
        
        $this->addColumn('{{%hotel}}', 'avg_rating', $this->decimal(3,2)->null()->after('estd'));
        $this->addColumn('{{%hotel}}', 'total_reviews', $this->integer()->notNull()->defaultValue(0)->after('avg_rating'));
        
        $this->addColumn('{{%holiday_package}}', 'avg_rating', $this->decimal(3,2)->null()->after('cancellation_policy'));
        $this->addColumn('{{%holiday_package}}', 'total_reviews', $this->integer()->notNull()->defaultValue(0)->after('avg_rating'));
    }

    public function down()
    {
        echo "m170329_072018_average_rating_to_related_table cannot be reverted.\n";

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
