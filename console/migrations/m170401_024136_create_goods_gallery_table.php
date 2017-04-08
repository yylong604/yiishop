<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_gallery`.
 */
class m170401_024136_create_goods_gallery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_gallery', [
            'id' => $this->primaryKey()->unsigned(),
            'goods_id' => $this->bigInteger(20)->unsigned()->comment('商品ID'),
            'path' => $this->string('255')->notNull()->comment('地址'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_gallery');
    }
}
