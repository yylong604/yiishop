<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170402_050000_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(50)->notNull()->unique()->comment('用户名'),
            'password'=>$this->string(50)->notNull()->comment('密码'),
            'email'=>$this->string(30)->notNull()->unique()->comment('邮箱'),
            'token'=>$this->string(32)->notNull()->comment('自动登录令牌'),
            'token_create_time'=>$this->string(32)->comment('令牌创建时间'),
            'add_time'=>$this->integer(11)->notNull()->comment('注册时间'),
            'last_login_time'=>$this->integer(11)->notNull()->comment('最后登录时间'),
            'last_login_ip'=>$this->integer(15)->comment('最后登录ip'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
