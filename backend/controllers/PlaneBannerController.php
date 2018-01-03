<?php

namespace backend\controllers;

use backend\models\SearchSql;
use Yii;
use backend\models\PlaneTicketBanner;
use backend\models\PlaneTicketBannerQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Qiniu\Auth;

/**
 * PlaneBannerController implements the CRUD actions for PlaneTicketBanner model.
 */
class PlaneBannerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PlaneTicketBanner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlaneTicketBannerQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlaneTicketBanner model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PlaneTicketBanner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        require_once '../../common/tools/yii2-qiniu/autoload.php';
        $ak = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sk = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $bucket = 'imgs';
        $auth = new Auth($ak, $sk);
        $token = $auth->uploadToken($bucket);
        return $this->render('create', [
            'token' => $token,
        ]);
    }
    /**
     * @关闭csrf验证
     */
    public function init()
    {
        $this->enableCsrfValidation = false;
    }
    /**
     * @添加数据 add
     */
    public function actionAdd()
    {
        $data = Yii::$app->request->post();
        try{
            if (empty($data['name'])) {
                throw new \Exception('name_val_null');
            }
            if (empty($data['pic'])) {
                throw new \Exception('pic_val_null');
            }
            if (!isset($data['sort'])) {
                throw new \Exception('sort_val_null');
            }
            if (empty($data['status'])) {
                throw new \Exception('status_val_null');
            }
            if (empty(Yii::$app->user->getId())) {
                throw new \Exception('admin_id_null');
            }
            $json_data = [
                'sharePic'   => "",
                'shareDes'   => "",
                'shareTitle' => "",
                'shareUrl'   => ""
            ];
            $add_data = [
                'desc'        => $data['name'],//图片描述（标题）
                'img_url'     => $data['pic'],//图片url地址
                'sort'        => $data['sort'],//排序值
                'status'      => $data['status'],//上下线
                'share_data'  => json_encode($json_data, JSON_UNESCAPED_UNICODE),//分享数据
                'create_time' => date('Y-m-d H:i:s'),//创建时间
                'admin_id'    => Yii::$app->user->getId()//操作人ID
            ];
            if (!empty($data['goods_url'])) {
                $add_data['turn_type'] = 1;
                $add_data['turn_data'] = $data['goods_url'];
            }
            $status = SearchSql::_InsertSqlExecute('plane_ticket_banner', $add_data);
            if (!$status) {
                throw new \Exception('plane_banner_insert_abnormal');
            }
        }catch (\Exception $e) {
            $errMsg = $e->getMessage();
            $errMap = [
                'name_val_null'   => '活动名称为必填项',
                'pic_val_null'    => '请选择图片',
                'sort_val_null'   => '请输入排序值',
                'status_val_null' => '请设定banner图状态',
                'admin_id_null'   => '操作异常',
                'plane_banner_insert_abnormal' => '数据添加失败'
            ];
            return isset($errMap[$errMsg])?$errMap[$errMsg]:'服务器内部异常';
        }
        return 'success';
    }

    /**
     * Updates an existing PlaneTicketBanner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        require_once '../../common/tools/yii2-qiniu/autoload.php';
        $ak = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sk = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $bucket = 'imgs';
        $auth = new Auth($ak, $sk);
        $token = $auth->uploadToken($bucket);
        $banner_sql = "SELECT `id`,`desc`,`img_url`,`turn_data`,`sort`,`status` FROM `plane_ticket_banner` WHERE `id`=:id";
        $banner_info = SearchSql::_SearchOneData($banner_sql,[
            ':id' => Yii::$app->request->get('id')
        ]);
        $img_info = [];
        if (!empty($banner_info)) {
            $img_info = [
                'img_info' => (empty($banner_info['img_url']) ? 0: 1),
                'img_str' => $banner_info['img_url'],//图片地址
            ];
        }
        return $this->render('update', [
            'banner_info' => $banner_info,
            'token'       => $token,
            'img_info'    => $img_info
        ]);
    }
    /**
     * @添加数据 add
     */
    public function actionReset()
    {
        $data = Yii::$app->request->post();
        try{
            if (!isset($data['id'])) {
                throw new \Exception('banner_id_null');
            }
            if (empty($data['name'])) {
                throw new \Exception('name_val_null');
            }
            if (empty($data['pic'])) {
                throw new \Exception('pic_val_null');
            }
            if (!isset($data['sort'])) {
                throw new \Exception('sort_val_null');
            }
            if (empty($data['status'])) {
                throw new \Exception('status_val_null');
            }
            if (empty(Yii::$app->user->getId())) {
                throw new \Exception('admin_id_null');
            }
            $json_data = [
                'sharePic'   => "",
                'shareDes'   => "",
                'shareTitle' => "",
                'shareUrl'   => ""
            ];
            $update_data = [
                'desc'        => $data['name'],//图片描述（标题）
                'img_url'     => $data['pic'],//图片url地址
                'sort'        => $data['sort'],//排序值
                'status'      => $data['status'],//上下线
                'share_data'  => json_encode($json_data, JSON_UNESCAPED_UNICODE),//分享数据
                'update_time' => date('Y-m-d H:i:s'),//修改时间
                'admin_id'    => Yii::$app->user->getId()//操作人ID
            ];
            if (!empty($data['goods_url'])) {
                $add_data['turn_type'] = 1;
                $add_data['turn_data'] = $data['goods_url'];
            }
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_banner', $update_data, ['id' => $data['id']]);
            if (!$status) {
                throw new \Exception('plane_banner_update_abnormal');
            }
        }catch (\Exception $e) {
            $errMsg = $e->getMessage();
            $errMap = [
                'banner_id_null'  => '请求异常',
                'name_val_null'   => '活动名称为必填项',
                'pic_val_null'    => '请选择图片',
                'sort_val_null'   => '请输入排序值',
                'status_val_null' => '请设定banner图状态',
                'admin_id_null'   => '操作异常',
                'plane_banner_update_abnormal' => '数据修改失败'
            ];
            return isset($errMap[$errMsg])?$errMap[$errMsg]:'服务器内部异常';
        }
        return 'success';
    }

    /**
     * Deletes an existing PlaneTicketBanner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlaneTicketBanner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlaneTicketBanner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlaneTicketBanner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @机票banner图片上线
     */
    public function actionUpBannerStatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $update_data = [
                'status'      => 1,
                'update_time' => date('Y-m-d H:i:s'),
                'admin_id'    => Yii::$app->user->getId()
            ];
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_banner', $update_data, ['id' => $id]);
            if ($status) {
                return 'success';
            } else {
                return 1;
            }
        } else {
            return '非法请求！';
        }
    }
    /**
     * @机票banner图片下线
     */
    public function actionLowBannerStatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $update_data = [
                'status'      => 2,
                'update_time' => date('Y-m-d H:i:s'),
                'admin_id'    => Yii::$app->user->getId()
            ];
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_banner', $update_data, ['id' => $id]);
            if ($status) {
                return 'success';
            } else {
                return 1;
            }
        } else {
            return '非法请求！';
        }
    }

}
