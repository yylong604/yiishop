<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170329_034701_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(50)->notNull()->comment('文章名'),
            'intro' => $this->text()->comment('简介'),
            'status' => $this->smallInteger()->defaultValue(1)->notNull()->comment('状态'),
            'sort' => $this->integer(4)->notNull()->defaultValue(20)->comment('排序'),
            'is_help' => $this->smallInteger()->defaultValue(1)->comment('帮助信息'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
