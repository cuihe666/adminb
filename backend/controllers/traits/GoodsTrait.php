<?php namespace backend\controllers\traits;

use backend\common\Helper;
use backend\components\exception\ApiException;
use backend\models\GoodsSearch;
use backend\models\ShopCategory;
use backend\models\ShopGoods;
use backend\models\ShopLogisticsTpl;
use backend\models\ShopSpec;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Request;

/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/7/15
 * Time: 下午2:34
 */
trait GoodsTrait
{
    /**
     * 存入 goods 表,返回商品 id
     * 这里更新和新增放到一起了
     * @param Request $request
     * @return bool|mixed
     */
    public function storeGoods(Request $request)
    {
        if ($id = $request->post('id')) {
            $model = ShopGoods::findOne($id);
            if (is_null($model)) {
                $model = new ShopGoods();
            }
        } else {
            $model = new ShopGoods();
        }


        $data = $this->buildGoodsData($request);

        Helper::loadModel($model, $data);

        if ($model->validate() && $model->save()) {
            return $model->getPrimaryKey();
        } else {
            throw new \Exception('参数格式不正确');
        }
    }

    /**
     * 构建完整的商品信息表单
     * @param Request $request
     * @return array
     */
    public function buildGoodsData(Request $request)
    {
        $data = $request->post();

        $data['admin_id'] = 123;
        $category_list = json_decode($data['category_breadcrumbs'], true);
        $data['category_id'] = end($category_list)['value'];
        //分类名
        $data['category_name'] = $this->getCategoryName($data['category_id']);

        //商品封面
        $post_image = json_decode($data['images'], true);
        $post_image = (isset($post_image[0]['url'])) ? $post_image[0]['url'] : '';
        $data['post_image'] = $post_image;

        //每次编辑都会重置为待审核上架状态
        $data['status'] = 0;


        return $data;
    }


    /**
     * @param   int $id 分类 id
     * @return bool|string
     */
    public function getCategoryName($id)
    {
        $name = ShopCategory::findOne(['id' => $id]);
        if (!is_null($name)) {
            return $name->title;
        } else {
            return false;
        }
    }


    /**
     * 添加商品规格值
     * @param Request $request
     * @param $goods_id
     * @return array
     */
    public function storeSpec(Request $request, $goods_id)
    {
        $spec_list = $request->post('spec_info');
        $spec_list = json_decode($spec_list, true);

        $data = [];
        foreach ($spec_list as $spec) {
            foreach ($spec['children'] as $spec_item) {
                $tpl = [
                    'title' => $spec_item['label'],
                    'spec_id' => $spec['value'],
                    'goods_id' => $goods_id,
                ];
                $data[] = $tpl;
            }
        }
        //删除旧数据
        $old = \Yii::$app->db->createCommand()
            ->delete('shop_spec_item', ['goods_id' => $goods_id])
            ->execute();
        //插入新数据
        $new = \Yii::$app->db->createCommand()
            ->batchInsert('shop_spec_item', ['title', 'spec_id', 'goods_id'], $data)
            ->execute();
        //获取新数据的 id
        $list = \Yii::$app->db
            ->createCommand("SELECT id,title FROM shop_spec_item WHERE goods_id = '{$goods_id}'")
            ->queryAll();

        return ArrayHelper::map($list, 'title', 'id');
    }

    public function storeStocks(Request $request, $goods_id, $spec_list)
    {
        $stocks = $request->post('sku_list');
        $stocks = json_decode($stocks, true);

        $data = [];
        foreach ($stocks as &$stock) {
            $tpl = [
                'goods_id' => $goods_id,
                'stocks' => $stock['stocks'],
                'price' => $stock['price'],
                'code' => $stock['code'],
            ];

            foreach ($stock['columns'] as $index => &$column) {
                $column['value'] = $spec_list[$column['label']];
                $index++;
                $tpl['attr' . $index] = $column['value'];
            }
            $tpl['title'] = json_encode($stock['columns']);

            $data[] = $tpl;
        }

        if (!empty($data)) {
            $column = array_keys(current($data));
            $sql = \Yii::$app->db->createCommand()
                ->batchInsert('shop_goods_stocks', $column, $data)
                ->execute();
            return $sql;
        } else {
            return 0;
        }

    }

    /**
     * 根据传入
     * @param null $params
     * @return array
     */
    public function getCategory($params = null)
    {

        if (is_null($params)) {
            $category = ShopCategory::find()->where(['pid' => 0])->asArray()->all();
            if (empty($category)) return ['code' => 401, 'error' => '数据库无信息'];
            return [
                'code' => 200,
                'category_list' => $this->buildCategoryList($category, true)
            ];
        } else {
            $pid = end($params);
            $category = ShopCategory::find()->where(['pid' => $pid])->asArray()->all();
            if (empty($category)) return ['code' => 401, 'error' => '数据库无信息'];
            $with_child = (count($params) < 2);
            return [
                'code' => 200,
                'category_list' => $this->buildCategoryList($category, $with_child),
                'with' => $with_child
            ];
        }
    }


    /**
     * 将从数据库中取出的 category 转换成前端可用的
     * @param array $data 从数据库中取出的 category 数组
     * @param boolean $with_child 是否在重组的数组中加入 children 部分
     * @return array
     * 返回数组格式
     * array:4 [▼
     * "value" => 0
     * "label" => "科技数码"
     * "id" => "1"
     * "children" => []
     * ]
     * 这里为了便于前端进行数组遍历,所以 value 存的是数组索引,而 id 才是真正的值
     */
    protected function buildCategoryList(array $data = [], $with_child = false)
    {
        $arr = [];
        foreach ($data as $index => $item) {
            $tpl = [
                'value' => $index,
                'label' => $item['title'],
                'id' => $item['id']
            ];
            if ($with_child) {
                $tpl['children'] = [];
            }
            $arr[] = $tpl;
        }
        return $arr;
    }

    /**
     * 获取商品规格列表
     * @return array
     */
    protected function getSpecList()
    {
        $spec = ShopSpec::find()->select(['id as value', 'key as label'])->asArray()->all();
        return $spec;
    }

    /**
     * 获取运费模板
     * @return array
     */
    protected function getPostTplList()
    {
        $admin_id = 123;
        $tpl = ShopLogisticsTpl::find()
            ->select(['id as value', 'title as label'])
            ->where(['admin_id' => $admin_id])
            ->asArray()->all();
        return $tpl;
    }

    protected function findModel($id)
    {
        if (($model = ShopGoods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('您寻找的商品不存在');
        }
    }

    /**
     * 通过goods_id 构建更新页面的内容
     * @param $model
     */
    protected function buildUpdateFormat(ShopGoods $model)
    {
        $base_form = $this->buildBaseForm($model);
        $img_list = $this->buildImgList($model);
        $params = $this->buildParams($model);
        $img_list_desc = $this->buildImgListDesc($model);

        if ($model->is_more) {
            $attr_block = $this->buildAttrBlock($model);
            $table_form = $this->buildTableForm($model);
        } else {
            $attr_block = $table_form = [];
        }

        $data = compact('base_form', 'img_list', 'img_list_desc', 'attr_block', 'table_form');
        $data = array_merge($data, $params);
        return $data;
    }

    protected function buildBaseForm(ShopGoods $model)
    {
        $data = [
            'id' => $model->id,
            'title' => $model->title,
            'barcode' => $model->barcode,
            'category_breadcrumbs' => $model->category_breadcrumbs,
            'code' => $model->code,
            'config' => $model->config,
            'description' => $model->description,
            'images' => $model->images,
            'introduction' => $model->introduction,
            'is_more' => (string)$model->is_more,
            'logistics_tpl_id' => (string)$model->logistics_tpl_id,
            'packing_list' => $model->packing_list,
            'price' => (string)$model->price,
            'stocks' => (string)$model->stocks,
            'warranty' => $model->warranty,
        ];
        return $data;
    }

    protected function buildImgList(ShopGoods $model)
    {
        return json_decode($model->images, true);
    }

    protected function buildImgListDesc(ShopGoods $model)
    {
        return [
            ['url' => $model->description, 'name' => $model->description]
        ];
    }

    protected function buildParams(ShopGoods $model)
    {
        $data = json_decode($model->attributes, true);
        $params_fix_block = [
            'product_code' => '',
            'brand' => '',
            'up_time' => '',
            'location' => '',
            'extra_label' => '',
            'extra_value' => '',
        ];
        $params_block = [];
        foreach ($data as $item) {
            switch ($item['label']) {
                case '货号':
                    $params_fix_block['product_code'] = $item['value'];
                    break;
                case '商品品牌':
                    $params_fix_block['brand'] = $item['value'];
                    break;
                case '上市时间' :
                    $params_fix_block['up_time'] = $item['value'];
                    break;
                case '产地':
                    $params_fix_block['产地'] = $item['value'];
                    break;
                default:
                    $params_block[] = $item;
            }
        }
        return compact('params_fix_block', 'params_block');
    }

    protected function buildAttrBlock(ShopGoods $model)
    {
        $config = json_decode($model->config, true);
        //需要查询的规格 id
        $attr_block = array_map(function ($item) {
            $res = [
                'child_new_value' => '',
                'child_value_list' => [],
                'children' => [],
            ];
            return array_merge($res, $item);
        }, $config);
        $spec_items = (new Query())->select('id as value,title as label,spec_id')
            ->from('shop_spec_item')
            ->where(['goods_id' => $model->id])
            ->all();
        $spec_items = ArrayHelper::index($spec_items, null, 'spec_id');

        foreach ($attr_block as &$item) {
            $item['children'] = isset($spec_items[$item['value']]) ? $spec_items[$item['value']] : [];
        }

        return $attr_block;
    }

    protected function buildTableForm(ShopGoods $model)
    {
        $stocks = $model->getStocks()->asArray()->all();
        $data = array_map(function ($item) {
            $columns = json_decode($item['title'], true);
            $title = ArrayHelper::getColumn($columns, 'label');
            $item['columns'] = $columns;
            $item['title'] = $title;
            return $item;
        }, $stocks);
        return $data;
    }

    /**
     * 组合商品列表
     * @param Request $request
     */
    protected function getGoodsList(Request $request)
    {
        $search_model = new GoodsSearch();
        $data_provider = $search_model->search($request->queryParams);


        $data = [
            'status' => 'all',
            'data' => ArrayHelper::toArray($data_provider->getModels()),
            'pagination' => [
                'current_page' => $request->get('page', 1),
                'page_size' => 10,
                'total' => $data_provider->getTotalCount()
            ]
        ];
        return $data;
    }

}