<?php

namespace backend\controllers;

use backend\models\Coupon;
use backend\models\CouponQuery;
use backend\models\User;
use backend\service\CommonService;
use backend\traits\AjaxTrait;
use common\tools\Helper;
use Yii;
use backend\models\CouponBatch;
use backend\models\CouponBatchQuery;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CouponController implements the CRUD actions for CouponBatch model.
 * Author: GPF
 */
class CouponController extends Controller
{
    use AjaxTrait;
    protected $request;
    protected $errors = null;
    protected $coupon_id = null;
    //优惠券审核的权限名
    public static $admin_role = '优惠券审核';
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
    public function init()
    {
        parent::init();
        $this->request = Yii::$app->getRequest();
        $this->coupon_id = $this->request->get('id',null);
    }

    //列表页
    public function actionIndex()
    {
        $searchModel = new CouponBatchQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //优惠券的列表页
    public function actionList($id){
        $searchModel = new CouponQuery();

        //用于导出列表的数据
        $outputProvider = $searchModel->search(null,Coupon::find()->with('users','used')->where(['batch_id' => $id]));
        //用于领取详情的展示
        $dataProvider = $searchModel->search($this->request->queryParams,Coupon::find()->with('users','used','receive')->where(['batch_id' => $id,'status' => [2,3]]));

        $batchModel = CouponBatch::findOne($id);

        //优惠券统计
        $count = $this->countCoupon($id);
        //统计剩余数量
//        $count['last'] = $batchModel->num - $count['count'];
        $count['last'] = $count['wait'];

        return $this->render('list',compact('dataProvider','searchModel','batchModel','outputProvider','coupon','id','count'));
    }

    //统计优惠券
    protected function countCoupon($id){
        $surplus = Yii::$app->db->createCommand("SELECT count(*) as num,status FROM coupon1 WHERE batch_id={$id} GROUP BY status")->queryAll();
        $status = ['wait' => 0,'used' => 0,'bind' => 0,'count' => 0];
        $surplus = ArrayHelper::map($surplus,'status','num');

        $status['wait'] = array_key_exists(1,$surplus)? $surplus[1] : 0;
        $status['used'] = array_key_exists(3,$surplus)? $surplus[3] : 0;
        $status['bind'] = array_key_exists(2,$surplus)? $surplus[2] + $status['used'] :   $status['used'];
//        foreach ($status as $item){
//            if(array_key_exists(1,$surplus) || array_key_exists(0,$surplus)) continue;
//            $status['count'] += $item;
//        }
        return $status;
    }


    //添加页面
    public function actionCreate()
    {
        $model = new CouponBatch();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    //禁用优惠券批次
    public function actionForbidden($id){
        $model = $this->findModel($id);

        if($model->status == 0){
            return $this->redirectAndMsg(['index'],'直接删了就好,何必禁用它呢?');
        }else{
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $res = $this->forbidden($model);
                $log =  Helper::log([
                    'record_id' => $model->id,
                    'table_name' => CouponBatch::tableName(),
                    'remark' => '禁用优惠券批次'
                ]);
                $transaction->commit();
                return $this->redirectAndMsg(['index'],'已禁用','success');
            }catch (Exception $exception){
                $transaction->rollBack();
                return $this->redirectAndMsg(['index'],'服务器繁忙,请求失败','error');
            }

        }
    }

    protected function forbidden(CouponBatch $batch){
        $batch->status = 4;
//        $coupon = Yii::$app->db->createCommand("UPDATE coupon1 SET status=4 WHERE batch_code='{$batch->batch_code}' AND batch_id={$batch->id} AND uid=0")->execute();
        $coupon = Yii::$app->db->createCommand()
            ->update(Coupon::tableName(),['status' => 4],"batch_code='{$batch->batch_code}' AND batch_id={$batch->id} AND uid IS NULL")
            ->execute();

        return ($batch->save() && $coupon);
    }

    //存储
    public function actionStore(){
        $data = $this->request->post();
        $res = $this->handleData($data);
        if($res['mode'] == 1){
            if($res['num'] > 10000) return $this->apiResponse([
                'code' => '403',
                'error' => '可导出优惠券的数量请在1万条以内'
            ]);
        }

        $mode = $this->getModel();
        if($mode->status >= 1){
            return $this->apiResponse([
                'code' => 403,
                'error' => '审核过后的批次不可再修改'
            ]);
        }
        Helper::loadModel($mode,$res);

        if($this->isRepeatTitle($mode)){
            return $this->apiResponse([
                'code' => '403',
                'error' => '使用了已存在的优惠券名称,如果复用优惠券请从<优惠券批次>中查找'
            ]);
        }

        if($mode->is_forever == 1){
            $mode->start_time = date('Y-m-d H:i:s',time());
            $mode->end_time = '2099-01-01 00:00:00';
        }


        //验证输入内容
        if($mode->validate() && $mode->save()){
            $data = [
                'code' => 200
            ];
        }else{
            $data = [
                'code' => 403,
                'error' => current(current($mode->getErrors()))
            ];
        }
        return $this->apiResponse($data);
    }

    /**
     * 检测重复批次名的方法
     * @param CouponBatch $batch
     * @return bool
     */
    protected function isRepeatTitle(CouponBatch $batch){
        //如果是编辑状态则查看 title 和 batch_code 是否一致
        //如果是新增的则验证 title 是否存在
//        var_dump($batch->id);
//        Helper::dd($batch);
        $res =  CouponBatch::find()->where(['title' => $batch->title])->select(['id','title','batch_code'])->one();
        if($batch->id){

            return ($res->batch_code != $batch->batch_code);
        }else{
//            $res =  CouponBatch::find()->where(['title' => $batch->title,'batch_code' => $batch->batch_code])->select(['id','title'])->one();
            if(is_null($res)) return false;
            return ($res->batch_code != $batch->batch_code);
        }
    }

    //处理提交的数据内容
    protected function handleData($data){
        //处理多余字段
        if(isset($data['_csrf-backend'])) unset($data['_csrf-backend']);

        //处理优惠券有效期
        if($data['is_forever'] == 0){
            $data['start_time'] .= ' 00:00:00';
            $data['end_time'] .= ' 23:59:59';
        }else{
            $data['start_time'] = null;
            $data['end_time'] = null;
        }

        //处理批次编码
        if(!$this->checkBatchCode($data['batch_code'])){
            $data['batch_code'] = $this->generateBatchCode();
        }

        //处理优惠券类型
        $data['rule_type'] = ($data['rule'] != 0)? 1 : 0;

        return $data;
    }
    //通过 ajax 请求获取批次信息
    public function actionBatchList(){
        $key = $this->request->get('key');
        $query = CouponBatch::find()
            ->where(['like','title',$key])
            ->select(['batch_code','title'])
            ->groupBy('batch_code')
            ->asArray()->all();
        return $this->apiResponse($query);
    }

    //检测批次编码是否存在数据库中
    protected function checkBatchCode($code){
        if(empty($code)) return false;
        return CouponBatch::find()->where(['batch_code' => $code])->exists();
    }
    //生成批次编码
    protected function generateBatchCode(){
        return uniqid() . '_' . date('ymd') . mt_rand(001,999);
    }


    //更新页面
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        Helper::dd($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    //删除数据
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->status != 0){
            return $this->redirectAndMsg(['index'],'已发放的优惠券不可删除!');
        }else{
            $model->delete();
            $log =  Helper::log([
                'record_id' => $model->id,
                'table_name' => CouponBatch::tableName(),
                'remark' => '删除优惠券批次'
            ]);
            return $this->redirectAndMsg(['index'],'已删除','success');
        }
    }

    //审核接口
    public function actionConfirm($id){
        $model = $this->getModel();
        if($model->id != $id || $model->status != 0) return $this->apiResponse(['code' => 403, 'error' => '已生成优惠券,无法再次修改']);


        $transition = Yii::$app->db->beginTransaction();
        try{
            $model->status = 1;
            $log =  Helper::log([
                'record_id' => $model->id,
                'table_name' => CouponBatch::tableName(),
                'remark' => '通过审核,生成优惠券'
            ]);

            if($model->save() && $this->batchInsert($model) && $log){
                $transition->commit();
                return $this->apiResponse(['code' => 200]);
            }else{
                $transition->rollBack();
            }
        }catch(Exception $exception){
            $transition->rollBack();
        }


        return $this->apiResponse([
            'code' => 500,
            'error' => '服务器繁忙,请稍候再试'
        ]);
    }

    //将优惠券批量生成
    protected function batchInsert($model){
        //如果是不可导出的模式时就不预生成优惠券
        if($model->mode == 0) return true;
        $info = $model->attributes;
        $info['status'] = 1;
        $num = $info['num'];

        //
        $prepare_column = ['title', 'rule', 'amount', 'is_forever' , 'mode' , 'type' , 'redeem_code' , 'start_time', 'end_time', 'uid' , 'batch_code', 'status', 'update_time', 'create_time', 'platform','rule_type','description'];
        $base_info = [];
        foreach($info as $key => $value){
            if(in_array($key,$prepare_column)){
                $base_info[$key] = $value;
            }
        }
        $base_info['batch_id'] = $model->id;


        $rows = [];
        for($i=0; $i<$num; $i++){
            if($base_info['mode'] == 1){
                $base_info['redeem_code'] = $this->generateRedeemCode();
            }
            $rows[] = $base_info;
        }

        return \Yii::$app->db->createCommand()
            ->batchInsert(Coupon::tableName(),array_keys(current($rows)),$rows)->execute();

    }

    //生成激活码
    protected function generateRedeemCode(){
        $code = uniqid();
        $code = substr($code,5,8);
        $base = 'qwertyupasdfghjklzxcvbnm23456789';
        $salt = '';
        for($i=0;$i<4;$i++){
            $salt .= $base[mt_rand(0,31)];
        }
        $code .= $salt;
        return strtoupper($code);
    }

    /**
     * Finds the CouponBatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CouponBatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CouponBatch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //自定义获取模型,如果 id 不存在将生成一个新的模型
    protected function getModel(){
        if($this->coupon_id){
            $model = CouponBatch::findOne($this->coupon_id);
            if(is_null($model)){
                return new CouponBatch();
            }
            return $model;
        }else{
            return new CouponBatch();
        }
    }



    //指定产品界面
    public function actionSpecial($id){
        $model = $this->findModel($id);

        //通过类型判定需要查找的范围
        switch ($model->type){
            //全部
            case 0:
                $tname_list = [
                    'house_details' => '民宿',
                    'travel_activity' => '活动',
                    'travel_higo' => '主题嗨go',
                    'hotel' => '酒店'
                ];
                break;
            //民宿
            case 1:
                $tname_list = [
                    'house_details' => '民宿',
                ];
                break;
            //旅行
            case 2:
                $tname_list = [
                    'travel_activity' => '活动',
                    'travel_higo' => '主题嗨go',
                ];
                break;
            case 3:
                $tname_list = [
                    'hotel' => '酒店'
                ];
                break;
            default:
                $tname_list = [];
        }


        return $this->render('special',compact('model','tname_list'));
    }

    /**
     * 处理 id 参数内容
     * @param string $ids
     * @return array
     */
    protected function handleIds($ids){
        $ids = explode(',',$ids);
        $ids = array_map(function($item){
            return (int)$item;
        },$ids);
        return $ids;
    }

    /**
     * 根据提供的 id 和表名查找出对应的产品信息
     * @param array $ids        id 数组
     * @param string $tname     表名
     * @return array
     */
    protected function searchIds(array $ids,$tname){
        $ids = implode(',',$ids);
        //根据不同的表取不同的字段
        $title = $this->switchTitle($tname);
        return Yii::$app->db->createCommand("SELECT id,{$title} as title FROM {$tname} WHERE id IN ({$ids})")->queryAll();
    }
    //根据 tname 返回对应的字段
    protected function switchTitle($tname){
        switch ($tname){
            case 'hotel':
                $title = 'short_name';
                break;
            case 'house_details':
                $title = 'title';
                break;
            case 'travel_higo':
                $title = 'name';
                break;
            case 'travel_activity':
                $title = 'name';
                break;
            default:
                $title = "";
        }
        return $title;
    }

    /**
     * coupon_special 的验证排重,返回重复的 product_id
     * 验证思路是相同 tname 中不能有重复的 product_id,有就说明已经对这条产品进行过操作了
     * @param array $ids        将要录入的 id 集合
     * @param string $tname     表名
     * @return array|string     重复的 id 的集合
     */
    protected function distinctSpecial($ids,$tname){
        $ids = implode(',',$ids);
        $query = Yii::$app->db->createCommand("SELECT batch_id,tname,product_id FROM coupon1_special WHERE batch_id={$this->coupon_id} AND tname='{$tname}' AND product_id IN ({$ids})")->queryAll();
        $ids = [];
        foreach($query as $row){
            $ids[] = $row['product_id'];
        }
        return $ids;
    }

    //根据提供的 id 来筛选出指定产品
    public function actionSearchIds(){
        $ids = "";
        $tname = "";
        $data = $this->request->post();
        extract($data);

        //处理 id 参数内容
        $ids = $this->handleIds($ids);
        //检测字段
        if(empty($ids) || empty($tname)) return $this->apiResponse(['code'=>403,'error'=>'参数错误']);

        $query = $this->searchIds($ids,$tname);
        if(empty($query)) return $this->apiResponse(['code'=>'403','error' => '输入的 id 未找到内容']);

        //排重
        $repeat = $this->distinctSpecial($ids,$tname);
        foreach($query as &$row){
            if(in_array($row['id'],$repeat)){
                $row['is_exist'] = 1;
            }else{
                $row['is_exist'] = 0;
            }
        }

        return $this->apiResponse(['code'=>200,'body'=>$query]);
    }

    //保存指定产品内容
    public function actionSpecialStore($id){
        $batch = CouponBatch::findOne($id);
        if(is_null($batch)) return $this->apiResponse(['code' => 403,'error' => '产品不存在']);
//        if($batch->status != 0) return $this->apiResponse(['code' => 403,'error' => '已生成的优惠券批次不可进行操作']);
        $ids = '';
        $tname = '';
        $post = $this->request->post();
        extract($post);

        //检测字段
        $allow = ['ids','tname','mode','type'];
        $error = false;
        foreach($allow as $value){
            if(!key_exists($value,$post)){
                $error = true;
            }
        }
        if($error) return $this->apiResponse(['code' => 403,'error' => '缺少字段']);

        //查询对应的产品名
        $data = ArrayHelper::map($this->searchIds($ids,$tname),'id','title');

        //构建要插入的数据结构
        $rows = [];
        foreach($ids as $product_id){
            $rows[] = [
                'mode' => $mode,
                'tname' => $tname,
                'type' => $type,
                'product_id' => $product_id,
                'batch_id' => $id,
                'title' => $data[$product_id],
            ];
        }

        //插入数据库
        $query = Yii::$app->db->createCommand()->batchInsert('coupon1_special',array_keys(current($rows)),$rows)->execute();


        if($query){
            return $this->apiResponse(['code' => 200]);
        }else{
            return $this->apiResponse(['code' => 500,'error'=>'服务器繁忙,稍候再试']);
        }
    }

    //获取受限产品列表
    public function actionSpecialList($id){
        $query = Yii::$app->db->createCommand("SELECT mode,type,product_id,title,batch_id,tname FROM coupon1_special WHERE batch_id='{$id}'")->queryAll();
        return $this->apiResponse(['code' => 200, 'body' => $query]);
    }

    //批量删除优惠券信息
    public function actionSpecialDel($id){
        $batch = CouponBatch::findOne($id);
        if(is_null($batch)) return $this->apiResponse(['code' => 403,'error' => '产品不存在']);
        if($batch->status != 0) return $this->apiResponse(['code' => 403,'error' => '已生成的优惠券批次不可进行操作']);

        $data = $this->request->post();
        if(!array_key_exists('tname',$data) || empty($data['tname'])){
            return $this->apiResponse(['code' => 403,'error' => '参数错误']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try{
            foreach($data['tname'] as $tname => $ids){
                $this->batchDelSpecial($tname,$ids);
            }
            $transaction->commit();
        }catch (Exception $exception){
            $transaction->rollBack();
            return $this->apiResponse(['code'=> 500,'error'=>$exception->getMessage()]);
        }

        return $this->apiResponse(['code'=>200]);
    }

    //根据 tname 删除指定产品
    protected function batchDelSpecial($tname,$ids){
        $query = Yii::$app->db->createCommand()->delete('coupon1_special',['tname' => $tname,'product_id' => $ids]);
        return $query->execute();
    }


    //获取优惠券具体列表
    public function actionTicketList(){
        $batch_code = Yii::$app->request->get('batch_code');
        $query = Coupon::find()
            ->select(['id','redeem_code','rule','amount','is_forever','start_time','end_time'])
            ->where([
                'batch_code' => $batch_code,
                'status' => 1
            ])
            ->limit(10)
            ->asArray()
            ->all();
        if(empty($query)) return $this->apiResponse(['code' => 403,'error'=>'优惠券已用完']);
        return $this->apiResponse(['code' => 200,'body' => $query]);
    }


    /**
     * 通过 id_phone 获取用户模型
     * @param string $id_phone
     * @return User
     */
    protected function getUserInfo($id_phone){
        if(Helper::isPhone($id_phone)){
            $condition = ['mobile'=>$id_phone];
        }else{
            $condition = ['id'=>$id_phone];
        }
        return User::find()->with('info','common')->where($condition)->select(['id','mobile'])->one();
    }
    //搜索用户信息
    public function actionSearchUser(){
        $id_phone = $this->request->post('id_phone',null);
        $user = $this->getUserInfo($id_phone);
        if(!$user) return $this->apiResponse(['code' => 403,'error' => '用户不存在']);

        $new = $this->getNewestOrder($user);

        $res = [
            'nickname' => $user->info->name?: '无',
            'name' => $user->common->nickname?: '无',
            'sex' => ($user->common->gender == 1)? '女' : '男',
            'order' => $new
        ];



        return $this->apiResponse(['code' => 200,'body' => $res]);
    }

    //获取用户最新开启的订单
    protected function getNewestOrder(User $user){
        $travel = $user->getTravelOrder()->select(['order_no as order_num','activity_date as create_time'])->limit(1)->asArray()->one();
        $house = $user->getHouseOrder()->select(['order_num','create_time'])->limit(1)->asArray()->one();
        $hotel = $user->getHotelOrder()->select(['order_num','create_time'])->limit(1)->asArray()->one();

        $arr = compact('travel','house','hotel');
        $res = [];
        foreach($arr as $key => $item){
            if(empty($item)) continue;
            $time = strtotime($item['create_time']);
            $item['type'] = $key;
            $item['time'] = $time;

            //只采用最新的订单
            if(empty($res)){
                $res = $item;
            }else{
                if($res['time'] > $item['time']){
                    continue;
                }else{
                    $res = $item;
                }
            }
        }

        return $res;
    }

    /**
     * 检测
     * @param $redeem_code
     * @return Coupon
     */
    protected function checkCoupon($redeem_code){
        return Coupon::findOne(['redeem_code' => $redeem_code]);
    }


    //绑定优惠券
    public function actionBindTicket(){
        $id_phone = $this->request->post('id_phone',null);
        $ticket = $this->request->post('ticket',null);
        if(empty($id_phone) || empty($ticket)) return $this->apiResponse(['code' => 403,'error' => '需要手机号和优惠券']);

        $user = $this->getUserInfo($id_phone);
        if(!$user) return $this->apiResponse(['code' => 403,'error' => '用户不存在']);

        $coupon = Coupon::findOne(['redeem_code' => $ticket,'status' => 1]);
        if(is_null($coupon) || empty($coupon->redeem_code)) return $this->apiResponse(['code' => 403,'error' => '优惠券编码不正确或已被使用']);

        $transaction = Yii::$app->db->beginTransaction();

        try{
            $res = $this->bindTicket($user,$coupon);
            $transaction->commit();
            $sms = $this->sendSms($user,$coupon);
            $response = ['code' => 200];
            if($sms){
                $response['msg'] = '短信已发送';
            } else{
                $response['msg'] = '短信未发送';
            }
        }catch (Exception $exception){
            $transaction->rollBack();
            $response = ['code' => 500, 'error' => '服务器繁忙,请稍候再试'];
        }

        return $this->apiResponse($response);
    }

    //向用户发送短信
    protected function sendSms(User $user,Coupon $coupon){
        $user_name = $user->common->nickname;
        $phone = $user->mobile;
        $amount = $coupon->amount;
        if($coupon->rule > 0){
            $rule = '满' . $coupon->rule . '元可用';
        }else{
            $rule = '无门槛';
        }
        $type = Yii::$app->params['coupon_tname_type'][$coupon->type];

        if(!empty($coupon->start_time)){
            $start = substr($coupon->start_time,2,8);
            $end = substr($coupon->end_time,2,8);
            $period = $start . '至' . $end;
        }else{
            $period = '永久有效';
        }
        $template = <<<str
【棠果科技】亲爱的 {$user_name} ,果果赠送您一张 {$amount} 元优惠券,使用条件: {$rule},使用范围: {$type},有效期: {$period},天天快乐哦~
str;

        return CommonService::sendSms($phone,$template);
    }

    /**
     * 批量绑定优惠券
     * @param User $phones
     * @param Coupon $tickets
     */
    protected function bindTicket(User $user,Coupon $ticket){
        $ticket->uid = $user->id;
        $ticket->status = 2;
        $ticket->update_time = date('Y-m-d H:i:s');
//        $batch = CouponBatch::find()->where(['batch_code' => $ticket->batch_code])->one();
//        Helper::dd($batch,$ticket);

        $row = [
            'uid' => $user->id,
            'coupon_id' => $ticket->id,
        ];
        //写入领取记录
        $coupon_receive = Yii::$app->db->createCommand()->insert('coupon1_receive',$row)->execute();

        //写入 admin_log 表
        $log =  Helper::log([
            'record_id' => $ticket->id,
            'table_name' => Coupon::tableName(),
            'remark' => '对用户发放优惠券',
            'user_id' => $user->id
        ]);

        return ($ticket->save() && $coupon_receive && $log);

    }


}
