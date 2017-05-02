<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_landing`.
 */
class m170501_231203_create_user_landing_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_landing', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(10)->notNull(),
            'landing_id' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_landing');
    }
}
