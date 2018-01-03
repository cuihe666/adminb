<?php

namespace backend\models;

use Codeception\Module\SkipHelper;
use Yii;

/**
 * This is the model class for table "shop_goods".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $status
 * @property string $category_name
 * @property string $title
 * @property string $code
 * @property string $barcode
 * @property string $price
 * @property integer $store
 * @property string $post_image
 * @property string $images
 * @property string $attributes
 * @property string $description
 * @property string $packing_list
 * @property integer $logistics_tpl_id
 * @property string $warranty
 * @property string $config
 * @property integer $admin_id
 * @property string $created_at
 * @property string $update_at
 */
class ShopGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'status', 'stocks', 'logistics_tpl_id', 'admin_id'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'update_at'], 'safe'],
            [['category_name', 'post_image'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 60],
            [['code', 'barcode', 'warranty'], 'string', 'max' => 45],
            [['images', 'description'], 'string', 'max' => 2000],
            [['attributes', 'packing_list'], 'string', 'max' => 500],
            [['config'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品id',
            'goods_num' => '商品编号',
            'category_breadcrumbs' => '三级分类面包屑',
            'category_id' => '商品分类 id',
            'status' => '商品状态0=>待申请上架,1=>审核中,2=>在售中,3=>仓库中(已下架),4=>',
            'category_name' => '商品分类name',
            'title' => '商品名称',
            'code' => '商品编码',
            'barcode' => '商品条形码',
            'price' => '价格',
            'stocks' => '商品库存',
            'post_image' => '商品封面',
            'images' => '商品详情中的轮播图 json',
            'attributes' => '商品属性参数json',
            'description' => '商品详情',
            'packing_list' => '包装清单',
            'logistics_tpl_id' => '运费模板 id',
            'warranty' => '保修时间',
            'config' => '商品属性配置项 json',
            'admin_id' => '供应商 id',
            'created_at' => '创建时间',
            'sort' => '排序',
            'update_at' => 'Update At',
            'introduction' => '商品简介',
            'is_more' => '是否多规格 1=>有 0=>没有',
        ];
    }

    public function getInfo()
    {
        return $this->hasOne(ShopInfo::className(), ['admin_id' => 'admin_id']);
    }

    public static function getTop_category()
    {
        return Yii::$app->db->createCommand("SELECT id,title FROM `shop_category` WHERE pid = 0")->queryAll();
    }

    public function getUpplier()
    {
        return $this->hasOne(ShopSupplier::className(), ['admin_id' => 'admin_id']);
    }

    public static function getTime($goods_id, $type)
    {
        return Yii::$app->db->createCommand("SELECT created_at FROM `shop_goods_log` WHERE  goods_id = {$goods_id} AND new_status = {$type}")->queryScalar();

    }


}
