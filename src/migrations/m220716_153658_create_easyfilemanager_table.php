<?php
namespace aditiya\easyfilemanager\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%easyfilemanagement}}`.
 */
class m220716_153658_create_easyfilemanager_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // minimal yii version : 2.0.14
        $this->createTable('{{%easyfilemanager}}', [
            'key' => $this->string(36)->notNull(), // to call the file
            'name' => $this->string(255)->notNull(), // formal name
            'extension' => $this->string(255)->notNull(), // original file extension
            'category' => $this->string(255)->null(), // file category
            'description' => $this->text()->null(), // just description
            'mimetype' => $this->string(255)->notNull(), // just description
            'roles' => $this->string(255)->defaultValue('["@","?"]'), // role to check
            'size' => $this->bigInteger()->null(), // file size in byte
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP'), // the time file reated in server
            'filepath' => $this->string(255)->notNull(), // where file stored
        ]);

        $this->addPrimaryKey('efm_key_primary','{{%easyfilemanager}}','key');
        $this->createIndex('efm_category_index','{{%easyfilemanager}}','category');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%easyfilemanager}}');
    }
}
