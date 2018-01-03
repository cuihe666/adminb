<?php

namespace backend\controllers;

use backend\models\PlaneTicketSupplier;
use backend\models\SearchSql;
use Qiniu\Auth;
use Yii;
use backend\models\PlaneTicketInsuranceGoodsManage;
use backend\models\PlaneTicketInsuranceGoodsManageQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InsuranceManageController implements the CRUD actions for PlaneTicketInsuranceGoodsManage model.
 */
class InsuranceManageController extends Controller
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
     * Lists all PlaneTicketInsuranceGoodsManage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlaneTicketInsuranceGoodsManageQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $insurance_info = PlaneTicketSupplier::find()
            ->where(['ticket_genre' => 0])
            ->select([
                'name',
                'id'
            ])
            ->asArray()
            ->all();
        $insurance_list = [];
        if (!empty($insurance_info)) {
            foreach ($insurance_info as $value) {
                $insurance_list[$value['id']] = $value['name'];
            }
        }
        return $this->render('index', [
            'searchModel'     => $searchModel,
            'dataProvider'    => $dataProvider,
            'insurance_list' => $insurance_list
        ]);
    }

    /**
     * Displays a single PlaneTicketInsuranceGoodsManage model.
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
     * Creates a new PlaneTicketInsuranceGoodsManage model.
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
        $insurance_info = PlaneTicketSupplier::find()
            ->where(['ticket_genre' => 0])
            ->select([
                'id',
                'name'
            ])
            ->asArray()
            ->all();
        return $this->render('create', [
            'token'     => $token,
            'list_info' => $insurance_info
        ]);
    }
    /**
     * @添加保险产品信息
     */
    public function actionAdd()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $insert_data = [
                    'supplier_id'   => $data['id'],
                    'type'          => $data['type'],
                    'price'         => $data['price'],
                    'insurance_fee' => $data['insurance_fee'],
                    'goods_id'      => $data['goods_id'],//保险商品ID（保险公司提供的）
                    'collection_method' => $data['collection_method'],//佣金比例（0.固定佣金 1.佣金比例）
                    'create_time'   => date('Y-m-d H:i:s'),
                    'admin_id'      => Yii::$app->user->getId()
                ];
                //判断用户选择的佣金收取方式，进行不同的存储（固定佣金+本金 or 佣金比例+本金）
                if ($data['collection_method'] == 1) {//佣金比例（0.固定佣金 1.佣金比例）
                    $insert_data['ratio'] = $data['ratio'];
                    //计算本金（本金 = 售价 * (1 - 佣金比例<ps:此处是数字，要/100，转化为百分比>) ）
                    $insert_data['cost_price'] = $data['price'] * (1 - $data['ratio']/100);
                    //计算固定佣金
                    $insert_data['commission'] = $data['price'] * ($data['ratio']/100);
                } else {//固定佣金金额
                    $insert_data['commission'] = $data['commission'];
                    //计算本金（本金 = 售价 - 固定佣金）
                    $insert_data['cost_price'] = $data['price'] - $data['commission'];
                    //计算佣金比例
                    $insert_data['ratio'] = round(($data['commission'] / $data['price']),2) * 100;
                }
                $add_status = SearchSql::_InsertSqlExecute('plane_ticket_insurance_goods_manage', $insert_data);
                if (!$add_status) {
                    throw new \Exception('insert_sql_abnormal');
                }
                if (!empty($data['pic'])) {
                    $id = Yii::$app->db->lastInsertID;
                    $pic_data = explode(',',trim($data['pic'],','));
                    $pic_name = explode(',',trim($data['pic_name'],','));
                    $add_data = [];
                    for ($i = 0; $i < count($pic_data); $i++) {
                        $add_data[] = [
                            $id,//goods_id
                            1,//file_type
                            $pic_name[$i],//file_name
                            $pic_data[$i],//file_url
                            date('Y-m-d H:i:s'),//create_time
                            Yii::$app->user->getId()//admin_id
                        ];
                    }
                    $name_info = ['goods_id', 'file_type', 'file_name', 'file_url', 'create_time', 'admin_id'];
                    $insert_status = SearchSql::_InsertManySqlExecute('plane_ticket_insurance_goods_aptitude', $name_info, $add_data);
                    if (!$insert_status) {
                        throw new \Exception('zizhi_insert_abnormal');
                    }
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                $errInfo = $e->getMessage();
                $errMap = [
                    'insert_sql_abnormal' => '添加失败',
                    'zizhi_insert_abnormal' => '添加失败'
                ];
                return isset($errMap[$errInfo])?$errMap[$errInfo]:'服务器内部异常';
            }
            return 'success';
        } else {
            return '非法请求！';
        }
    }

    /**
     * Updates an existing PlaneTicketInsuranceGoodsManage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        require_once '../../common/tools/yii2-qiniu/autoload.php';
        $ak = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sk = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $bucket = 'imgs';
        $auth = new Auth($ak, $sk);
        $token = $auth->uploadToken($bucket);
        $id = Yii::$app->request->get('id');
        $insurance_info = PlaneTicketSupplier::find()
            ->where(['ticket_genre' => 0])
            ->select([
                'id',
                'name'
            ])
            ->asArray()
            ->all();
        $supplier_info = PlaneTicketInsuranceGoodsManage::find()
            ->where(['id' => $id])
            ->asArray()
            ->one();
        $img_sql = 'SELECT `file_url`,`file_name` FROM `plane_ticket_insurance_goods_aptitude` WHERE `goods_id`=:id';
        $img_data = SearchSql::_SearchAllData($img_sql, [
            ':id' => $id
        ]);
        $img_for = [];
        $name_for = [];
        if (!empty($img_data)) {
            foreach ($img_data as $v) {
                $img_for[] = $v['file_url'];
                $name_for[] = $v['file_name'];
            }
        }
        $img_info = [
            'img_info' => $img_data,
            'img_str'  => implode(',', $img_for),
            'name_str' => implode(',', $name_for),
        ];
        return $this->render('update', [
            'list_info' => $insurance_info,
            'supplier_info'  => $supplier_info,
            'token'     => $token,
            'img_info'  => $img_info
        ]);
    }
    /**
     * @修改保险产品信息
     */
    public function actionReset()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $update_data = [
                    'supplier_id'   => $data['supplier_id'],
                    'type'          => $data['type'],
                    'price'         => $data['price'],
                    'insurance_fee' => $data['insurance_fee'],
                    'goods_id'      => $data['goods_id'],//保险商品ID（保险公司提供的）
                    'collection_method' => $data['collection_method'],//佣金比例（0.固定佣金 1.佣金比例）
                    'update_time'   => date('Y-m-d H:i:s'),
                    'admin_id'      => Yii::$app->user->getId()
                ];
                //判断用户选择的佣金收取方式，进行不同的存储（固定佣金+本金 or 佣金比例+本金）
                if ($data['collection_method'] == 1) {//佣金比例（0.固定佣金 1.佣金比例）
                    $update_data['ratio'] = $data['ratio'];
                    //计算本金（本金 = 售价 * (1 - 佣金比例<ps:此处是数字，要/100，转化为百分比>) ）
                    $update_data['cost_price'] = $data['price'] * (1 - $data['ratio']/100);
                    //计算固定佣金
                    $update_data['commission'] = $data['price'] * ($data['ratio']/100);
                } else {//固定佣金金额
                    $update_data['commission'] = $data['commission'];
                    //计算本金（本金 = 售价 - 固定佣金）
                    $update_data['cost_price'] = $data['price'] - $data['commission'];
                    //计算佣金比例
                    $update_data['ratio'] = round(($data['commission'] / $data['price']),2) * 100;
                }
                $update_status = SearchSql::_UpdateSqlExecute('plane_ticket_insurance_goods_manage', $update_data, ['id' => $data['id']]);
                if (!$update_status) {
                    throw new \Exception('update_supplier_abnormal');
                }
                //清除旧图片数据
                $del_sql = "DElETE FROM `plane_ticket_insurance_goods_aptitude` WHERE `goods_id`=:id";
                Yii::$app->db->createCommand($del_sql)
                    ->bindValues([
                        ':id' => $data['id']
                    ])
                    ->execute();
                if (!empty($data['pic'])) {
                    //添加图片信息
                    $pic_data = explode(',', trim($data['pic'], ','));
                    $name_data = explode(',', trim($data['pic_name'], ','));
                    $add_data = [];
                    for ($i = 0; $i < count($pic_data); $i++) {
                        $add_data[] = [
                            $data['id'],//goods_id
                            1,//file_type
                            $name_data[$i],//file_name
                            $pic_data[$i],//file_url
                            date('Y-m-d H:i:s'),//create_time
                            Yii::$app->user->getId()//admin_id
                        ];
                    }
                    $name_info = ['goods_id', 'file_type', 'file_name', 'file_url', 'create_time', 'admin_id'];
                    $insert_status = SearchSql::_InsertManySqlExecute('plane_ticket_insurance_goods_aptitude', $name_info, $add_data);
                    if (!$insert_status) {
                        throw new \Exception('zizhi_insert_abnormal');
                    }
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                $errInfo = $e->getMessage();
                dd($errInfo);
                $errMsg = [
                    'update_supplier_abnormal' => '修改失败',
                    'del_aptitude_abnormal' => '修改失败',
                    'zizhi_insert_abnormal' => '修改失败'
                ];
                return isset($errMsg[$errInfo])?$errMsg[$errInfo]:'服务器内部异常';
            }
            return 'success';
        } else {
            return '非法请求！';
        }
    }

    /**
     * Deletes an existing PlaneTicketInsuranceGoodsManage model.
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
     * Finds the PlaneTicketInsuranceGoodsManage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlaneTicketInsuranceGoodsManage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlaneTicketInsuranceGoodsManage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @上线保险产品
     */
    public function actionUpGoodsStatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $update_data = [
                'status' => 1,
                'update_time' => date('Y-m-d H:i:s'),
                'admin_id'    => Yii::$app->user->getId()
            ];
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_insurance_goods_manage', $update_data, ['id' => $id]);
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
     * @下线保险产品
     */
    public function actionLowGoodsStatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $update_data = [
                'status' => 2,
                'update_time' => date('Y-m-d H:i:s'),
                'admin_id'    => Yii::$app->user->getId()
            ];
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_insurance_goods_manage', $update_data, ['id' => $id]);
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
