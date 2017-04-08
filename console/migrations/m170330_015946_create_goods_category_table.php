<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170330_015946_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'parent_id'=>$this->integer()->notNull()->comment('分类id'),
            'intro'=>$this->text()->comment('介绍'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
