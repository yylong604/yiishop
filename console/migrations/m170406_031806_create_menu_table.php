<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170406_031806_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->comment('上级菜单'),
            'url' => $this->string()->comment('路由'),
            'name' => $this->string()->notNull()->comment('名称'),
            'description' => $this->string()->comment('描述'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
