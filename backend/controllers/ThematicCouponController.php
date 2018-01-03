<?php

namespace backend\controllers;
use backend\models\Coupon1ActivityQuery;
use backend\models\ThematicActivity;
use backend\models\ThematicQrcode;
use PHPUnit\Framework\Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\models\ThematicActivityQuery;

/**
 * TravelOrderController implements the CRUD actions for TravelOrder model.
 */
class ThematicCouponController extends Controller
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
     * 专题优惠券列表
     */

    public function actionIndex(){
        $thematicId = intval(trim(Yii::$app->request->get("id")));
        if($thematicId==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        //专题信息
        $thematicInfo = ThematicActivity::findOne($thematicId);
        //获取专题绑定的优惠券大礼包（json格式）
        $couponJson = $thematicInfo->coupon_activity_id;
        //json转换为数组格式（包括all，old，new三个二维数组）
        $couponArr = json_decode($couponJson,true);
        //将二维数组合并成一维数组
        if($couponArr)
            $couponArrN = array_merge($couponArr['all'],$couponArr['old'],$couponArr['new']);
        else
            $couponArrN = [];
        $searchModel = new Coupon1ActivityQuery();
        $searchModel->coupon_activity_id = $couponArrN;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'thematicId' => $thematicId,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'thematicInfo' => $thematicInfo,
        ]);
    }

    /**
     * 添加优惠券
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionCreate(){
        $thematicId = intval(trim(Yii::$app->request->get("id")));
        if($thematicId==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        $thematic = ThematicActivity::findOne($thematicId);
        if(Yii::$app->request->isPost){
            $trans = Yii::$app->db->beginTransaction();
            try{
                $params = Yii::$app->request->post();
                $activity_id = $thematicId.date("ymdHis");
                $ins = Yii::$app->db->createCommand("INSERT INTO coupon1_activity(activity_id,title,daily_max,storage,net_stock,start_time,end_time,create_at,update_at,status) VALUES (:activity_id,:title,:daily_max,:storage,:net_stock,:start_time,:end_time,:create_at,:update_at,:status)")
                    ->bindValue(":activity_id",$activity_id)
                    ->bindValue(":title",$params['Coupon1Activity']['title'])
                    ->bindValue(":daily_max",$params['Coupon1Activity']['daily_max'])
                    ->bindValue(":storage",$params['Coupon1Activity']['storage'])
                    ->bindValue(":net_stock",$params['Coupon1Activity']['storage'])
                    ->bindValue(":start_time",$params['Coupon1Activity']['start_time'])
                    ->bindValue(":end_time",$params['Coupon1Activity']['end_time'])
                    ->bindValue(":create_at",date("Y-m-d H:i:s"))
                    ->bindValue(":update_at","")
                    ->bindValue(":status",$params['Coupon1Activity']['status'])
                    ->execute();
                if($params['batch_code']){
                    $insertValue = [];
                    foreach($params['batch_code'] as $key=>$val){
                        $insertValue[] = [$activity_id,$params['batch_id'][$key],$val,$params['used_num'][$key],date("Y-m-d H:i:s",time())];
                    }
                    $ins_b = Yii::$app->db->createCommand()
                        ->batchInsert('coupon1_activity_batch', ['activity_id','batch_id', 'batch_code','used_num','create_time'], $insertValue)
                        ->execute();
                }
                $coupon = json_decode($thematic->coupon_activity_id,true);
                if($coupon)
                    $couponArr = $coupon;
                else
                    $couponArr = [
                        'all' => [],
                        'old' => [],
                        'new' => [],
                    ];
                //优惠券发放对象 所有用户
                if($params['Coupon1Activity']['object']==0){
                    $couponArr['all'][] = $activity_id;
                }
                //优惠券发放对象 老用户
                if($params['Coupon1Activity']['object']==1){
                    $couponArr['old'][] = $activity_id;
                }
                //优惠券发放对象 新用户
                if($params['Coupon1Activity']['object']==2){
                    $couponArr['new'][] = $activity_id;
                }
                $couponJson = json_encode($couponArr);
                Yii::$app->db->createCommand("UPDATE thematic_activity SET coupon_activity_id = :coupon_activity_id WHERE id = :id")
                    ->bindValue(":coupon_activity_id",$couponJson)
                    ->bindValue(":id",$thematicId)
                    ->execute();
                $trans->commit();
                return $this->redirect(['index','id'=>$thematicId]);
            } catch(Exception $e){
                $trans->rollBack();
                throw $e;
            }
        }
        return $this->render('create', [
            'model' => $thematic,
            'thematicId' => $thematicId,
        ]);
    }

    public function actionUpdate(){
        $thematicId = intval(trim(Yii::$app->request->get("tid")));
        $id = intval(trim(Yii::$app->request->get("id")));
        if($thematicId==0 || $id==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        $thematic = ThematicActivity::findOne($thematicId);
        if(Yii::$app->request->isPost){
            $trans = Yii::$app->db->beginTransaction();
            try{
                $params = Yii::$app->request->post();
                //dump($params);//exit;
                $activity_id = $params['activity_id'];
                //修改优惠券活动表
                $ins = Yii::$app->db->createCommand("UPDATE coupon1_activity SET title=:title,daily_max=:daily_max,storage=:storage,start_time=:start_time,end_time=:end_time,update_at=:update_at,status=:status WHERE id=:id")
                    ->bindValue(":title",$params['Coupon1Activity']['title'])
                    ->bindValue(":daily_max",$params['Coupon1Activity']['daily_max'])
                    ->bindValue(":storage",$params['Coupon1Activity']['storage'])
                    ->bindValue(":start_time",$params['Coupon1Activity']['start_time'])
                    ->bindValue(":end_time",$params['Coupon1Activity']['end_time'])
                    ->bindValue(":update_at",date("Y-m-d H:i:s"))
                    ->bindValue(":status",$params['Coupon1Activity']['status'])
                    ->bindValue(":id",$id)
                    ->execute();
                //删除原先的优惠券活动关联的优惠券批次表
                $del = Yii::$app->db->createCommand("DELETE FROM coupon1_activity_batch WHERE activity_id=:activity_id")
                    ->bindValue(":activity_id",$activity_id)
                    ->execute();
                //
                if($params['batch_code']){
                    $insertValue = [];
                    foreach($params['batch_code'] as $key=>$val){
                        $insertValue[] = [$activity_id,$params['batch_id'][$key],$val,$params['used_num'][$key],date("Y-m-d H:i:s",time())];
                    }
                    //dump($insertValue);exit;
                    $ins_b = Yii::$app->db->createCommand()
                        ->batchInsert('coupon1_activity_batch', ['activity_id','batch_id', 'batch_code','used_num','create_time'], $insertValue)
                        ->execute();
                }
//                Yii::$app->db->createCommand("UPDATE thematic_activity SET coupon_activity_id = :coupon_activity_id WHERE id = :id")
//                    ->bindValue(":coupon_activity_id",$thematic->coupon_activity_id.",".$activity_id)
//                    ->bindValue(":id",$thematicId)
//                    ->execute();
                $trans->commit();
                return $this->redirect(['index','id'=>$thematicId]);
            } catch(Exception $e){
                $trans->rollBack();
                throw $e;
            }
        }
        //优惠券礼包活动
        $activity = Yii::$app->db->createCommand("SELECT * FROM coupon1_activity WHERE id = :id")
            ->bindValue("id",$id)
            ->queryOne();
        //优惠券礼包中包含的优惠券批次
        $batch = Yii::$app->db->createCommand("SELECT * FROM coupon1_activity_batch as a left join coupon1_batch as c on a.batch_id = c.id WHERE activity_id=:activity_id ")
            ->bindValue(":activity_id",$activity['activity_id'])
            ->queryAll();
        return $this->render('update', [
            'thematic' => $thematic,
            'thematicId' => $thematicId,
            'activity' => $activity,
            'batch' => $batch,
        ]);
    }

    /**
     * 查询所有符合条件的优惠券列表
     * @return null|string
     */
    public function actionGetCouponBatch(){
        if (Yii::$app->request->isAjax) {
            $name = Yii::$app->request->get('name');
            $date=date('Y-m-d H:i:s',time());
            if($name=='')
                return null;
            $batch = Yii::$app->db->createCommand("SELECT * FROM coupon1_batch WHERE batch_code LIKE '%".$name."%' or title like '%".$name."%' AND type IN(0,2) AND '".$date."'<=end_time AND mode = 0 AND status = 1")->queryAll();
            return json_encode($batch);
        }
    }

    public function actionGetCouponBatchList(){
        if (Yii::$app->request->isAjax) {
            $code = Yii::$app->request->get('code');
            $date=date('Y-m-d H:i:s',time());
            if($code=='')
                return null;
            $batch = Yii::$app->db->createCommand("SELECT * FROM coupon1_batch WHERE batch_code = '".$code."' AND type IN(0,2) AND '".$date."'<=end_time AND mode = 0 AND status = 1")->queryAll();
            return json_encode($batch);
        }
    }

}
