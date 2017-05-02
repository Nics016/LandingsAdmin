<?php

use yii\db\Migration;

/**
 * Handles the creation of table `landing`.
 */
class m170428_144149_create_landing_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('landing', [
            'landing_id' => $this->primaryKey(),
            'title' => $this->string(32),
            
            'meters' => $this->integer()->notNull()->defaultValue(0),
            'floor' => $this->string(32)->notNull(),
            'state' => $this->smallInteger()->notNull()->defaultValue(10),
            'planning' => $this->smallInteger()->notNull()->defaultValue(10),
            'price' => $this->integer()->notNull()->defaultValue(0),
            'price_sign' => $this->smallInteger()->notNull()->defaultValue(10),
            'object_photo' => $this->text(),

            'about_text' => $this->text()->notNull(),
            'characteristics_text' => $this->text()->notNull(),
            'photos' => $this->text(),
            'news_text' => $this->text()->notNull(),
            'infostructure_text' => $this->text()->notNull(),
            'arendator_photos' => $this->text(),
            'location_text' => $this->text()->notNull(),
            'contacts_text' => $this->text()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('landing');
    }
}
