<?php

namespace backend\models;

use app\models\Brand;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property string $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property string $stock
 * @property string $is_on_sale
 * @property string $status
 * @property string $sort
 * @property string $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    public static $sale_options=[1=>'上架',0=>'下架'];
    public static $status_options=[1=>'正常',0=>'回收站'];

    // public $logo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'brand_id', 'market_price', 'shop_price', 'stock', 'is_on_sale', 'status','logo'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'inputtime'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['sn'], 'string', 'max' => 15],
            [['sort'], 'safe'],
            ['goods_category_id','depthValue'],
        ];
    }

    /*
     * 自定义规则
     */
    public function depthValue()
    {
        $re = GoodsCategory::findOne(['id'=>$this->goods_category_id]);
        if(!($re && $re->depth == 2)){
            $this->addError('goods_category_id','不能添加到第三级');
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sn' => '货号',
            'logo' => '图片',
            'goods_category_id' => '分类id',
            'brand_id' => '品牌id',
            'market_price' => '市场售价',
            'shop_price' => '本地售价',
            'stock' => '库存',
            'is_on_sale' => '上架',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
        ];
    }

    //获得品牌下拉框的值
    public static function getBrand_id()
    {
        $brand_id=Brand::find()->all();
        return ArrayHelper::map($brand_id,'id','name');
    }

    //显示图片
    public function logoUrl()
    {
        if(strpos($this->logo,'http://')===false){
            return '@web'.$this->logo;
        }
        return $this->logo;
    }


}
