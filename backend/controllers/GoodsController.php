<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/7/7
 * Time: 下午6:00
 */

namespace backend\controllers;

use backend\common\traits\AjaxTrait;
use backend\common\traits\CommonTrait;
use backend\controllers\traits\GoodsTrait;
use Qiniu\Auth;
use yii\filters\VerbFilter;
use yii\web\Controller;

class GoodsController extends Controller
{
    use AjaxTrait, CommonTrait, GoodsTrait;
    public $layout = 'main1';
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        $this->request = \Yii::$app->request;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'store' => ['post'],
                ],
            ],
        ];
    }


    //创建商品页
    public function actionCreate()
    {
        return $this->render('create');
    }

    //更新商品页
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        try {
            $res = $this->buildUpdateFormat($model);

        } catch (\Exception $exception) {
            return $this->apiResponse([
                'code' => 400,
                'error' => $exception->getMessage()
            ]);
        }

        return $this->render('update', ['resource' => json_encode($res)]);
    }

    //商品列表页面
    public function actionIndex()
    {
        $status_list = \Yii::$app->params['goods_status_list'];
        $status_list = json_encode($status_list);
        return $this->render('index', compact('status_list'));
    }

    public function actionGoodsList()
    {
        $request = $this->request;
        $list = $this->getGoodsList($request);
        return $this->apiResponse(['code' => 200, 'message' => $list]);
    }

    /**
     * 存入商品逻辑
     * 1. 先存 goods 表,获取 goods_id
     * 2. 再存spec_item 表.获取对应的规格值 id
     * 3. 将规格值 id 反赋值给 table_form 中,组成 sku 内容存入 good_stocks 表
     */
    public function actionStore()
    {
        $request = $this->request;
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $goods_id = $this->storeGoods($request);
            if ($request->post('is_more')) {
                $spec_list = $this->storeSpec($request, $goods_id);
                $stocks = $this->storeStocks($request, $goods_id, $spec_list);
            }
            $transaction->commit();
            return $this->apiResponse(['code' => 200, 'goods_id' => $goods_id]);
        } catch (\Exception $exception) {

            $transaction->rollBack();
//            dd('exception',$exception->getMessage());

            return $this->apiResponse(['code' => 400, 'error' => $exception->getMessage()]);
        }
    }


    /**
     * 获取商品分类三级联动接口
     */
    public function actionCategoryList()
    {
        $list = $this->request->get('category', null);

        $category = $this->getCategory($list);

        return $this->apiResponse($category);
    }

    /**
     * 获取 规格列表/品牌/产地/运费模板 这类资源的接口
     */
    public function actionResource()
    {
        $types = $this->request->get('type');

        $res = [];
        foreach ($types as $type) {
            switch ($type) {
                case 'brand_list':
                    $res['brand_list'] = \Yii::$app->params['brand_list'];
                    break;
                case 'local_list':
                    $res['local_list'] = \Yii::$app->params['local_list'];
                    break;
                case 'post_tpl_list':
                    $res['post_tpl_list'] = $this->getPostTplList();
                    break;
                case 'spec_list':
                    $res['spec_list'] = $this->getSpecList();
                    break;
            }
        }
        $data = empty($res) ? ['code' => 400, 'error' => '请求的资源不存在'] : ['code' => 200, 'resource' => $res];

        return $this->apiResponse($data);
    }

    /**
     * 改变状态的接口
     */
    public function actionChangeStatus()
    {
        $request = $this->request;
        $status = $request->post('status', null);
        $id_arr = json_decode($request->post('id_arr', '[]'));
        if (!$status || empty($id_arr)) {
            return $this->apiResponse(['code' => 400, 'error' => '请求参数错误']);
        }
        try {
            $res = $this->changeGoodsStatus($status, $id_arr);
            if ($res) {
                return $this->apiResponse(['code' => 200, 'message' => '操作成功']);
            } else {
                return $this->apiResponse(['code' => 200, 'message' => '未发生改变']);
            }
        } catch (\Exception $exception) {
            return $this->apiResponse(['code' => 400, 'error' => $exception->getMessage()]);
        }

    }

    public function actionToken()
    {
        require_once '../../common/tools/yii2-qiniu/autoload.php';
        $ak = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sk = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $bucket = 'imgs';
        $auth = new Auth($ak, $sk);
        $token = $auth->uploadToken($bucket);
        return $this->apiResponse(['code' => 200, 'token' => $token, 'host' => 'http://img.tgljweb.com/']);
    }

}