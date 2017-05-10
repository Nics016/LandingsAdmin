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
            'phone' => $this->string(32),
            'address' => $this->string(128),
            'email' => $this->string(128),

            'about_text' => $this->text()->notNull(),
            'characteristics_text' => $this->text()->notNull(),
            'photos' => $this->text(),
            'bg_photo' => $this->text(),
            'news_text' => $this->text()->notNull(),
            'infostructure_text' => $this->text()->notNull(),
            'arendator_photos' => $this->text(),

            'location_text' => $this->text()->notNull(),
            'latitude' => $this->decimal(30,15)->notNull(),
            'longitude' => $this->decimal(30,15)->notNull(),
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
