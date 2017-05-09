<?php

use yii\db\Migration;

/**
 * Handles the creation of table `place`.
 */
class m170508_231801_create_place_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('place', [
            'place_id' => $this->primaryKey(),
            'landing_id' => $this->integer()->notNull(),
            'meters' => $this->decimal(10, 1)->notNull()->defaultValue(0),
            'floor' => $this->string(32)->notNull(),
            'state' => $this->smallInteger()->notNull()->defaultValue(10),
            'planning' => $this->smallInteger()->notNull()->defaultValue(10),
            'price' => $this->integer()->notNull()->defaultValue(0),
            'price_sign' => $this->smallInteger()->notNull()->defaultValue(10),
            'object_photos' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('place');
    }
}
