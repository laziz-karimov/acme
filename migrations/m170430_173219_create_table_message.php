<?php

use yii\db\Migration;

class m170430_173219_create_table_message extends Migration {

    public function up() {
        $this->createTable('message', [
            'id' => $this->primaryKey()->unsigned(),
            'from_user_id' => $this->integer()->unsigned()->notNull(),
            'to_user_id' => $this->integer()->unsigned()->notNull(),
            'trip_id' => $this->integer()->unsigned()->notNull(),
            'text' => $this->text()->notNull(),
            'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
        
        $this->createIndex('idx_message_from_user_id_user', 'message', 'from_user_id');
        $this->addForeignKey('fk_message_from_user_id_user', 'message', 'from_user_id', 'user', 'id', 'restrict', 'cascade');
        
        $this->createIndex('idx_message_to_user_id_user', 'message', 'to_user_id');
        $this->addForeignKey('fk_message_to_user_id_user', 'message', 'to_user_id', 'user', 'id', 'restrict', 'cascade');
        
        $this->createIndex('idx_message_trip_id_trip', 'message', 'trip_id');
        $this->addForeignKey('fk_message_trip_id_trip', 'message', 'trip_id', 'trip', 'id', 'restrict', 'cascade');
    }

    public function down() {
        $this->dropForeignKey('fk_message_from_user_id_user', 'message');
        $this->dropIndex('idx_message_from_user_id_user', 'message');

        $this->dropForeignKey('fk_message_to_user_id_user', 'message');
        $this->dropIndex('idx_message_to_user_id_user', 'message');

        $this->dropForeignKey('fk_message_trip_id_trip', 'message');
        $this->dropIndex('idx_message_trip_id_trip', 'message');
        
        $this->dropTable('message');
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
