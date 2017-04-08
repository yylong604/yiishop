<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170329_061004_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'article_category_id'=>$this->smallInteger()->unsigned()->notNull()->comment('文章分类'),
            'intro'=>$this->string(50)->comment('简介'),
            'status'=>$this->smallInteger()->notNull()->defaultValue(1)->comment('状态'),
            'sort'=>$this->smallInteger()->notNull()->defaultValue(20)->comment('排序'),
            'inputtime'=>$this->integer()->unsigned()->notNull()->defaultValue(0)->comment('添加时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
