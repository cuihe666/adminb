<?php

namespace backend\controllers;

use backend\models\SearchSql;
use Qiniu\Auth;
use Yii;
use backend\models\PlaneTicketSupplier;
use backend\models\PlaneTicketSupplierQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlaneSupplierController implements the CRUD actions for PlaneTicketSupplier model.
 */
class PlaneSupplierController extends Controller
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
     * @机票供应商管理列表
     *
     */
    public function actionIndex()
    {
        $searchModel = new PlaneTicketSupplierQuery();
        $searchModel['supplier_note'] = 'supplier';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlaneTicketSupplier model.
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
     * Creates a new PlaneTicketSupplier model.
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
     * @添加供应商数据信息
     */
    public function actionAdd()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $insert_data = [
                    'name' => $data['name'],
                    'ticket_genre' => $data['type'],
                    'address' => $data['address'],
                    'contacts' => $data['contacts'],
                    'contacts_phone' => $data['contacts_phone'],
                    'create_time' => date('Y-m-d H:i:s'),
                    'admin_id' => Yii::$app->user->getId()
                ];
                $add_status = SearchSql::_InsertSqlExecute('plane_ticket_supplier', $insert_data);
                if (!$add_status) {
                    throw new \Exception('insert_sql_abnormal');
                }
                $id = Yii::$app->db->lastInsertID;
                $pic_data = explode(',', trim($data['pic'], ','));
                $add_data = [];
                for ($i = 0; $i < count($pic_data); $i++) {
                    $add_data[] = [
                        $id,//supplier_id
                        1,//file_type
                        $pic_data[$i],//file_url
                        date('Y-m-d H:i:s'),//create_time
                        Yii::$app->user->getId()//admin_id
                    ];
                }
                $name_info = ['supplier_id', 'file_type', 'file_url', 'create_time', 'admin_id'];
                $insert_status = SearchSql::_InsertManySqlExecute('plane_ticket_supplier_aptitude', $name_info, $add_data);
                if (!$insert_status) {
                    throw new \Exception('zizhi_insert_abnormal');
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                $errInfo = $e->getMessage();
                $errMap = [
                    'insert_sql_abnormal' => '添加失败',
                    'zizhi_insert_abnormal' => '添加失败'
                ];
                return isset($errMap[$errInfo]) ? $errMap[$errInfo] : '服务器内部异常';
            }
            return 'success';
        } else {
            return '非法请求！';
        }
    }

    /**
     * Updates an existing PlaneTicketSupplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     */
    public function actionUpdate()
    {
        require_once '../../common/tools/yii2-qiniu/autoload.php';
        $ak = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sk = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $bucket = 'imgs';
        $auth = new Auth($ak, $sk);
        $token = $auth->uploadToken($bucket);
        $id = Yii::$app->request->get('id');
        $supplier_info = PlaneTicketSupplier::find()
            ->where([
                'id' => $id
            ])
            ->asArray()
            ->one();
        $img_sql = 'SELECT `file_url` FROM `plane_ticket_supplier_aptitude` WHERE `supplier_id`=:id';
        $img_data = SearchSql::_SearchAllData($img_sql, [
            ':id' => $id
        ]);
        $img_for = [];
        if (!empty($img_data)) {
            foreach ($img_data as $v) {
                $img_for[] = $v['file_url'];
            }
        }
        $img_info = [
            'img_info' => $img_data,
            'img_str' => implode(',', $img_for),
        ];
        return $this->render('update', [
            'supplier_info' => $supplier_info,
            'token'         => $token,
            'img_info'      => $img_info
        ]);
    }
    /**
     * @修改机票供应商
     */
    public function actionReset()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $update_data = [
                    'name' => $data['name'],
                    'ticket_genre' => $data['type'],
                    'address' => $data['address'],
                    'contacts' => $data['contacts'],
                    'contacts_phone' => $data['contacts_phone'],
                    'update_time' => date('Y-m-d H:i:s'),
                    'admin_id' => Yii::$app->user->getId()
                ];
                $update_status = SearchSql::_UpdateSqlExecute('plane_ticket_supplier', $update_data, ['id' => $data['id']]);
                if (!$update_status) {
                    throw new \Exception('update_supplier_abnormal');
                }
                //清除旧图片数据
                $del_sql = "DElETE FROM `plane_ticket_supplier_aptitude` WHERE `supplier_id`=:id";
                $del_status = Yii::$app->db->createCommand($del_sql)
                    ->bindValues([
                        ':id' => $data['id']
                    ])
                    ->execute();
                if (!$del_status) {
                    throw new \Exception('del_aptitude_abnormal');
                }
                //添加图片信息
                $pic_data = explode(',', trim($data['pic'], ','));
                $add_data = [];
                for ($i = 0; $i < count($pic_data); $i++) {
                    $add_data[] = [
                        $data['id'],//supplier_id
                        1,//file_type
                        $pic_data[$i],//file_url
                        date('Y-m-d H:i:s'),//create_time
                        Yii::$app->user->getId()//admin_id
                    ];
                }
                $name_info = ['supplier_id', 'file_type', 'file_url', 'create_time', 'admin_id'];
                $insert_status = SearchSql::_InsertManySqlExecute('plane_ticket_supplier_aptitude', $name_info, $add_data);
                if (!$insert_status) {
                    throw new \Exception('zizhi_insert_abnormal');
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                $errInfo = $e->getMessage();
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
     * Deletes an existing PlaneTicketSupplier model.
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
     * Finds the PlaneTicketSupplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlaneTicketSupplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlaneTicketSupplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @供应商上线操作
     */
    public function actionUpSupplierStatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $update_data = [
                'is_use' => 1,
                'update_time' => date('Y-m-d H:i:s'),
                'admin_id'    => Yii::$app->user->getId()
            ];
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_supplier', $update_data, ['id' => $id]);
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
     * @供应商下线操作
     */
    public function actionLowSupplierStatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $update_data = [
                'is_use' => 2,
                'update_time' => date('Y-m-d H:i:s'),
                'admin_id'    => Yii::$app->user->getId()
            ];
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_supplier', $update_data, ['id' => $id]);
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
