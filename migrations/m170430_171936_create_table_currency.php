<?php

use yii\db\Migration;

class m170430_171936_create_table_currency extends Migration {

    public function safeUp() {
        $this->createTable('currency', [
            'id' => $this->primaryKey()->unsigned(),
            'code' => $this->string(3)->unique()->notNull(),
            'sign_format' => $this->string(45)->notNull()
        ]);

        $this->batchInsert('currency', ['code', 'sign_format'], [
            ['AUD' , 'A$ [price]'],
            ['BGN' , '[price] лв.'],
            ['BRL' , 'R$ [price]'],
            ['CAD' , 'C$ [price]'],
            ['CHF' , '[price] CHF'],
            ['CZK' , 'Kč [price]'],
            ['DKK' , 'dkr [price]'],
            ['EUR' , '€ [price]'],
            ['GBP' , '£ [price]'],
            ['HRK' , '[price] kn'],
            ['HUF' , 'Ft [price]'],
            ['JPY' , '¥ [price]'],
            ['KRW' , '₩ [price]'],
            ['NOK' , 'nkr [price]'],
            ['PLN' , '[price] zł'],
            ['RUB' , '[price] руб'],
            ['SEK' , 'skr [price]'],
            ['TRY' , '[price] TL'],
            ['USD' , '$ [price]'],
        ]);
    }

    public function safeDown() {
        $this->delete('currency');

        $this->dropTable('currency');
    }

}
