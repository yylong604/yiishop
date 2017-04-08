<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m170401_092610_create_goods_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_intro', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer()->unsigned()->notNull()->comment('商品ID'),
            'content' => $this->text()->comment('内容'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_intro');
    }
}
