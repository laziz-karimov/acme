<?php

use yii\db\Migration;

class m170430_172359_create_table_trip extends Migration {

    public function up() {
        $this->createTable('trip', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'from' => $this->integer()->unsigned()->notNull(),
            'to' => $this->integer()->unsigned()->notNull(),
            'date' => $this->dateTime()->notNull(),
            'number_seats' => $this->integer(4)->notNull(),
            'duration' => $this->decimal(10, 1)->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'currency_id' => $this->integer()->unsigned()->notNull(),
            'status' => $this->integer(4)->notNull()->defaultValue(1),
            'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated' => $this->timestamp()->notNull()
        ]);
        
        $this->createIndex('idx_trip_user_id_user', 'trip', 'user_id');
        $this->addForeignKey('fk_trip_user_id_user', 'trip', 'user_id', 'user', 'id', 'restrict', 'cascade');
        
        $this->createIndex('idx_trip_from_place', 'trip', 'from');
        $this->addForeignKey('fk_trip_from_place', 'trip', 'from', 'place', 'id', 'restrict', 'cascade');
        
        $this->createIndex('idx_trip_to_place', 'trip', 'to');
        $this->addForeignKey('fk_trip_to_place', 'trip', 'to', 'place', 'id', 'restrict', 'cascade');
        
        $this->createIndex('idx_trip_currency_id_currency', 'trip', 'currency_id');
        $this->addForeignKey('fk_trip_currency_id_currency', 'trip', 'currency_id', 'currency', 'id', 'restrict', 'cascade');
    }

    public function down() {
        $this->dropForeignKey('fk_trip_user_id_user', 'trip');
        $this->dropIndex('idx_trip_user_id_user', 'trip');

        $this->dropForeignKey('fk_trip_from_place', 'trip');
        $this->dropIndex('idx_trip_from_place', 'trip');

        $this->dropForeignKey('fk_trip_to_place', 'trip');
        $this->dropIndex('idx_trip_to_place', 'trip');

        $this->dropForeignKey('fk_trip_currency_id_currency', 'trip');
        $this->dropIndex('idx_trip_currency_id_currency', 'trip');
        
        $this->dropTable('trip');
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
