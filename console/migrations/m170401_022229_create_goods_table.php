<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170401_022229_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'sn' => $this->string(15)->notNull()->comment('货号'),
            'logo' => $this->string(150)->notNull()->comment('图片'),
            'goods_category_id' => $this->smallInteger()->notNull()->comment('分类id'),
            'brand_id' => $this->smallInteger()->notNull()->comment('品牌id'),
            'market_price' => $this->decimal(10,2)->unsigned()->notNull()->comment('市场售价'),
            'shop_price' => $this->decimal(10,2)->unsigned()->notNull()->comment('本地售价'),
            'stock' => $this->integer(11)->unsigned()->notNull()->comment('库存'),
            'is_on_sale' => $this->integer(4)->unsigned()->notNull()->comment('上架'),
            'status' => $this->integer(4)->unsigned()->notNull()->comment('状态'),
            'sort' => $this->integer(4)->unsigned()->notNull()->defaultValue(20)->comment('排序'),
            'inputtime' => $this->integer(11)->unsigned()->notNull()->comment('录入时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
