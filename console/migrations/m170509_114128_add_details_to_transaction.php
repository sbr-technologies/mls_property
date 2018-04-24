<?php

use yii\db\Migration;

class m170509_114128_add_details_to_transaction extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('{{%transaction}}', 'transaction_id', 'transactionid');
        $this->renameColumn('{{%transaction}}', 'paid_amount', 'amt');
        $this->alterColumn('{{%transaction}}', 'amt', $this->decimal(6, 2));
        $this->addColumn('{{%transaction}}', 'currencycode', $this->string(5)->null()->after('amt'));
        $this->addColumn('{{%transaction}}', 'receiveremail', $this->string(125)->null()->after('currencycode'));
        $this->addColumn('{{%transaction}}', 'receiverid', $this->string(125)->null()->after('receiveremail'));
        $this->addColumn('{{%transaction}}', 'payerid', $this->string(125)->null()->after('receiverid'));
        $this->addColumn('{{%transaction}}', 'payerstatus', $this->string(125)->null()->after('payerid'));
        $this->addColumn('{{%transaction}}', 'timestamp', $this->string(125)->null()->after('payerstatus'));
        $this->addColumn('{{%transaction}}', 'correlationid', $this->string(125)->null()->after('timestamp'));
        $this->addColumn('{{%transaction}}', 'receiptid', $this->string(125)->null()->after('correlationid'));
        $this->addColumn('{{%transaction}}', 'paymenttype', $this->string(125)->null()->after('receiptid'));
        $this->addColumn('{{%transaction}}', 'paymentstatus', $this->string(125)->null()->after('paymenttype'));
        $this->dropColumn('{{%transaction}}', 'subs_start');
        $this->dropColumn('{{%transaction}}', 'subs_end');
        
        $this->addColumn('{{%subscription}}', 'transaction_id', $this->bigInteger()->null()->after('plan_id'));
    }

    public function safeDown()
    {
        $this->renameColumn('{{%transaction}}', 'transactionid', 'transaction_id');
        $this->renameColumn('{{%transaction}}', 'amt', 'paid_amount');
        $this->dropColumn('{{%transaction}}', 'currencycode');
        $this->dropColumn('{{%transaction}}', 'receiveremail');
        $this->dropColumn('{{%transaction}}', 'receiverid');
        $this->dropColumn('{{%transaction}}', 'payerid');
        $this->dropColumn('{{%transaction}}', 'payerstatus');
        $this->dropColumn('{{%transaction}}', 'timestamp');
        $this->dropColumn('{{%transaction}}', 'correlationid');
        $this->dropColumn('{{%transaction}}', 'receiptid');
        $this->dropColumn('{{%transaction}}', 'paymenttype');
        $this->dropColumn('{{%transaction}}', 'paymentstatus');
        $this->addColumn('{{%transaction}}', 'subs_start', $this->integer()->null()->after('paymentstatus'));
        $this->addColumn('{{%transaction}}', 'subs_end', $this->integer()->null()->after('subs_start'));
        
        
        $this->dropColumn('{{%subscription}}', 'transaction_id');
        
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
