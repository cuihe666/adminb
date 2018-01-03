<?php

namespace backend\controllers;

use app\controllers\SmspushController;
use backend\models\DtCitySeas;
use backend\models\Hotel;
use backend\models\HotelContact;
use backend\models\HotelOrderQuery;
use backend\models\HotelQuery;
use backend\models\HotelSupplierAccount;
use backend\models\HotelSupplierSettlement;
use backend\models\HotelSupplierSettlementQuery;
use backend\models\HotelUser;
use backend\service\HotelSupplierService;
use backend\traits\AjaxTrait;
use backend\traits\SupplierTrait;
use common\tools\Helper;
use phpDocumentor\Reflection\Types\Null_;
use Yii;
use backend\models\HotelSupplier;
use backend\models\HotelSupplierQuery;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\traits\HouseOthers;

/**
 * HotelSupplierController implements the CRUD actions for HotelSupplier model.
 */
class HotelSupplierController extends Controller
{
    use AjaxTrait,SupplierTrait,HouseOthers;
    //供应商 id
    protected $supplier_id = null;
    //判定是否是新加
    protected $is_new = true;
    //当前的 model
    protected $model = null;
    public $enableCsrfValidation = false;

    public static $permission = null;

    //request 类
    public $request;
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
        $this->supplier_id = $this->request->get('id',null);
    }


    /**
     * 供应商列表
     */
    public function actionIndex()
    {
        $searchModel = new HotelSupplierQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Yii::$app->session->set('token',md5("@hot#456".time()));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'is_frontend' => $this->checkPermission('酒店供应商(客户端)'),
            'is_backend' => $this->checkPermission('酒店供应商(后台)')
        ]);
    }

    //通过审核
    public function actionAllow(){
        return $this->changeStatus(1,'酒店供应商(后台)');
    }

    //拒绝审核
    public function actionForbidden(){
        return $this->changeStatus(2,'酒店供应商(后台)');
    }

    //停用该供应商
    public function actionStop(){
        return $this->changeStatus(3,'酒店供应商(客户端)');
    }

    //启用该供应商
    public function actionBegin(){
        return $this->changeStatus(1,'酒店供应商(客户端)');
    }

    /**
     * 统一修改状态的方法
     * @param $code         int          //状态码
     * @param $permission   string       //相关权限
     * @return \yii\web\Response
     */
    protected function changeStatus($code,$permission){
        if(!$this->checkPermission($permission)){
            return $this->redirectAndMsg('/hotel-supplier/index','没有相关权限,请联系管理员');
        }

        //验证 model 是否存在
        $model = $this->getModel();
        if($this->is_new){
            return $this->redirectAndMsg('/hotel-supplier/index','不存在的 id');
        }

        //验证用户是否存在
        $user = Yii::$app->user->getIdentity();
        if(is_null($user)){
            return $this->redirectAndMsg('/site/login','请先登录');
        }



        //验证提交是否合法
        $req = [
            'id' => $this->supplier_id,
            'token'  => $this->request->get('token','asd'),
            'oldStatus' => $this->request->get('oldStatus','0'),
            'status' => $this->request->get('status',$code),
            'msg' => $this->request->get('msg',''),
        ];
        $token = Yii::$app->session->get('token');
        Yii::$app->session->set('token',null);
        //验证 token
        if($code == 2 & $token != $req['token'] && mb_strlen($req['msg']) < 2){
            return $this->redirectAndMsg('/hotel-supplier/index','验证出错');
        }

        //执行录入库的操作
        $model->status = $code;
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if($model->save() && HotelSupplierService::statusLog($req)){
                $transaction->commit();
                return $this->redirectAndMsg('/hotel-supplier/index','已修改','');
            }else{
                $transaction->rollBack();
                return $this->redirectAndMsg('/hotel-supplier/index','保存失败','错误');
            }

        }catch (\Exception $e){
            $transaction->rollBack();
            return $this->redirectAndMsg('/hotel-supplier/index','保存失败','错误');
        }
    }


    //检测用户权限
    protected function checkPermission($permission){
        if(self::$permission == null){
            $permissions = Yii::$app->getAuthManager()->getPermissionsByUser(Yii::$app->user->id);
            $permissions = array_keys($permissions);
            self::$permission = $permissions;
        }

//        var_dump(in_array($permission,self::$permission));
//        Helper::dd(self::$permission,$permission);

        return in_array($permission,self::$permission);
    }

    /**
     * 基本信息
     * @return mixed
     */
    public function actionAdd()
    {


        if($this->request->isPost){
            if($this->storeBaseInfo()){
                return $this->redirectAndMsg('/hotel-supplier/account?id='.$this->supplier_id,'保存成功','');
            }
        }

        $searchModel = $this->getModel();

        if($this->is_new){
            $cityAndProvince = [];
        }else{
            $cityAndProvince = $this->getCityAndProvince($searchModel);
        }


        return $this->render('add', [
            'searchModel' => $searchModel,
            'current' => $this->action->id,
            'addressCode' => $cityAndProvince,
        ]);
    }

    /**
     * 存储供应商的基本信息
     */
    protected function storeBaseInfo(){
        $model = $this->getModel();

        //新加供应商添加创建日期
        if($this->is_new){
            $model->create_time = date('Y-m-d H:i:s');
        }


        if($model->load($this->request->post()) && $model->validate() && $model->save()){
            $this->supplier_id = $model->primaryKey;
            $this->model = $model;
            if($this->is_new){
                $this->storeTempList();
            }
            return true;
        }else{
            $this->alertMsg('error', current(current($model->getErrors())));
            return false;
        }
    }


    /**
     * 保存存储在缓存当中的列表内容
     */
    protected function storeTempList(){
        $temp_list = Yii::$app->session->get('temp_contact_list',false);
        if(!$temp_list) return;
        $temp_list = array_map(function($item){
            $item['theme_id'] = $this->supplier_id;
            return $item;
        },$temp_list);

        $safe_columns = array_keys((new HotelContact())->attributeLabels());


        $rows = [];
        foreach ($temp_list as $item){
            foreach($item as $key => &$value){
                if(!in_array($key,$safe_columns)){
                    unset($item[$key]);
                }
            }
            $rows[] = $item;
        }

        if(!empty($rows)){
            $keys = array_keys($rows[0]);
            $res = Yii::$app->db->createCommand()->batchInsert(HotelContact::tableName(),$keys,$rows)->execute();
        }



        Yii::$app->session->set('temp_contact_list',[]);
    }

    /**
     * 账号信息
     * @return string
     */
    public function actionAccount()
    {


        if($this->request->isPost){
            if($this->storeAccount()){
                return $this->redirectAndMsg('/hotel-supplier/credentials?id='.$this->supplier_id,'保存成功','');
            }else{
                return $this->redirect('/hotel-supplier/account?id='.$this->supplier_id);
            }
        }

        //未添加时的跳转
        if($this->checkHotelSupplier()){
            //跳转到添加模型当中
            return $this->redirectAndMsg('/hotel-supplier/add','请完善基本信息','');
        }


        $model = $this->getAccountModel();

        return $this->render('account', [
            'model' => $model,
            'current' => $this->action->id,
            'supplier_id' => $this->supplier_id,
        ]);
    }

    /**
     * 存储账户信息
     * @return bool
     */
    protected function storeAccount(){
        $request = $this->request->post();

        $model = $this->getAccountModel();

        if($model->load($request) && $model->validate() && $model->save()){
            $this->supplier_id = $model->supplier_id;
            $this->alertMsg('success', '保存成功');
            return true;
        }else{
            $this->alertMsg('error', current(current($model->getErrors())));
            return false;
        }
    }

    /**
     * 供应商资质上传部分
     * @return string
     */
    public function actionCredentials(){
        if ($this->request->isPost){
            if($this->storeCredential()){

                //图片 json 转 array
                $model = $this->getModel();

                if($model->start_time && $model->end_time){
//                    $this->alertMsg('success','保存成功');
                    return $this->redirectAndMsg('/hotel-supplier/credentials?id='.$this->supplier_id,'保存成功','');
                }else{
                    return $this->redirectAndMsg('/hotel-supplier/credentials?id='.$this->supplier_id,'请输入完整的合同有效期','');
                }
            }else{
                return $this->redirectAndMsg('/hotel-supplier/credentials?id='.$this->supplier_id,'未发生修改','');
            }
        }

        $model = $this->getModel();
        if($this->is_new){
            return $this->redirectAndMsg('/hotel-supplier/add','请完善基本信息','info');

        }

        //图片 json 转 array
        $this->decodeImage($model);

        return $this->render('credential',[
            'supplier_id' => $this->supplier_id,
            'model' => $model
        ]);
    }

    /**
     * 资质审核存储内容接口
     * @return bool
     */
    protected function storeCredential(){
        $request = $this->request->post();

        $model = $this->getModel();

        $this->handleImage($request,$model);

        $error_info = $this->imageValidate($request,$model);


        //如果必须的内容都没有则直接报错
        if(is_bool($error_info)){
            $this->alertMsg('error','营业执照/特种行业许可证/合作协议 至少需要一个');
            return false;
        }

        //如果存在非法的字段,就只移除非法的字段
        if(!empty($error_info)){
            $this->alertMsg('error','有内容未保存完整,请检查');
            Yii::$app->session->setFlash('error_info',$error_info);
        }


        $model->id = $this->supplier_id;
        $model->start_time = $request['start_time'];
        $model->end_time = $request['end_time'];

        unset($request['start_time']);
        unset($request['end_time']);
        unset($request['file']);
        //如果没有提交内容就返回false
        if(empty($request) && $model->start_time == $model->getOldAttribute('start_time') && $model->end_time == $model->getOldAttribute('end_time')){
            return false;
        }


        if($model->save()){
            return true;
        }else{
            $error = $model->getErrors();
            $this->alertMsg('error',current(current($error)));
            return false;
        }
    }

    protected function imageValidate($request,HotelSupplier &$model){
        //移除违规的字段内容
        $check = $model->validate();
        $errors = $model->getErrors();
        $error_info = [];
        if (!$check){
            foreach($errors as $key => $error){
                $old = $model->getOldAttribute($key);
                $model->$key = $old;
                $error_info[$key] = '超出可上传的文件数量上限,未能保存';
            }
        }

        //三个字段中至少存在一个
        $required_params = false;
        $check_list = ['business_license','license','agreement'];
        foreach($check_list as $item){
            if(!empty($model->$item)){
                $required_params = true;
            }
        }
        if(!$required_params){
            return false;
        }

        return $error_info;
//        Helper::dd($errors,$request,$error_info,$model);

    }

    /**
     * 将图片地址整合到数据库当中
     * @param $request
     * @param $model
     */
    protected function handleImage($request,&$model){
//        $cdn_url = '//img.tgljweb.com/';
        $cdn_url = '';
        $check_list = ['business_license','license','agreement','other'];

        foreach($check_list as $key){
            if(isset($request[$key]) && !empty($request[$key])){
                $old_image = $model->$key?:'[]';
                $old_image = json_decode($old_image,true);

                $new_image = array_map(function($item,$key) use($cdn_url){
                    return [
                        'name' => $key,
                        'url' => $item
                    ];
                },$request[$key],array_keys($request[$key]));


                $new_image = array_merge($old_image,$new_image);
                $model->$key = json_encode($new_image);
            }
        }
//        Helper::dd($model,$request);
    }

    /**
     * 理论上是将图片字段json转数组，但是没用上，就改成了空字符串转空json
     * @param $model
     */
    protected function decodeImage(&$model){
        $check_list = ['business_license','license','agreement','other'];
        foreach($check_list as $key){
            $model->$key = empty($model->$key)? '[]' : $model->$key;
            $item = json_decode($model->$key,true);

            $arr = array_map(function($item){
                //为了兼容老版本
                if(!is_array($item)){
                    $item = [
                        'name' => $item,
                        'url' => $item,
                    ];
                }
                $item['type'] = (Helper::isImageExt($item['url']))? 'image' : 'file';
                return $item;
                },$item);
            $model->$key = json_encode($arr);
        }
    }


    /**
     * ajax删除资质审核图片
     */
    public function actionDelImage(){
        $request = Helper::requestPayload();
        $model = $this->getModel();

        if(!isset($request['index']) || !isset($request['name'])){
            return $this->apiResponse(['code'=>403,'msg'=>'参数格式错误']);
        }
        if($this->is_new){
            return $this->apiResponse(['code'=>403,'msg'=>'不存在的id']);
        }

        $allow = ['business_license','license','agreement','other'];
        if(!in_array($request['name'],$allow)){
            return $this->apiResponse(['code'=>402,'msg'=>'非法字段']);
        }

        if($this->delImage($model,$request)){
            return $this->apiResponse(['code'=>200,'msg'=>$request]);
        }else{
            return $this->apiResponse(['code'=>500,'msg'=>'error']);
        }

//        Helper::dd($request,$model);
    }

    protected function delImage($model,$request){
        $image = $model->$request['name'];
        $image = json_decode($image,true);
        array_splice($image,$request['index'],1);

        $model->$request['name'] = json_encode($image);
        return $model->save();
    }


    /**
     * 供应商关联酒店页面
     * @return string
     */
    public function actionRelation(){
        $model = $this->getModel();
        if($this->is_new){
            return $this->redirectAndMsg('/hotel-supplier/add','请完善基本信息','');
        }

        //搭建hotel 的 dataPProvider
        $query = Hotel::find()->andWhere(['supplier_id'=>$this->supplier_id]);
        $dataProvider = new ActiveDataProvider();
        $dataProvider->query = $query;


        return $this->render('relation', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 供应商绑定酒店的操作接口
     */
    public function actionBundle(){
        $supplier_id = $this->supplier_id;
        $hotel_id = $this->request->get('hotel_id',null);

        $model = Hotel::findOne($hotel_id);

        if(is_null($model) || $model->supplier_id != $supplier_id){
//            Helper::dd('不存在的 hotel_id');
            return $this->redirectAndMsg('/hotel-supplier/relation?id='.$supplier_id,'不存在的 hotel_id','error');
        }

        if($model->supplier_relation == 0){
            $model->supplier_relation = 1;
            $msg = '已关联';
        }else{
            $model->supplier_relation = 0;
            $msg = '已解除关联';
        }

        if($model->save()){
            return $this->redirectAndMsg('/hotel-supplier/relation?id='.$supplier_id,$msg,'success');
        }else{
            return $this->redirectAndMsg('/hotel-supplier/relation?id='.$supplier_id,'服务器繁忙,稍后重试','error');
        }
    }


    /**
     * 供应商结算页面
     * @return string|\yii\web\Response
     */
    public function actionFinance(){
        $show_type = Yii::$app->request->get('show_type',null);


        $supplierModel = $this->getModel();

        if($this->is_new){
            return $this->redirectAndMsg('/hotel-supplier/add','请完善基本信息','');
        }

        //供应商账户信息部分
        $accountModel = HotelSupplierAccount::findOne(['supplier_id' => $this->supplier_id]);
        if (is_null($accountModel)){
            return $this->redirectAndMsg('/hotel-supplier/account?id='.$this->supplier_id,'请先完善账号信息');
        }


        //计算统计总量部分
        if($supplierModel->settle_type){
            $settle_type = 'month';
        }else{
            $settle_type = 'week';
        }
        //动态计算统计总数据
        $doneCount = $this->STGetTotalBill($supplierModel,'done',$settle_type);
        $waitCount = $this->dynamicCompute($supplierModel,'wait',$settle_type);




        //当需要显示结算列表时的处理
        if($show_type){
            $queryParams = Yii::$app->request->queryParams;
            if(!isset($queryParams['HotelOrderQuery']) ||empty($queryParams['HotelOrderQuery']['start_end'])){
                $key = $show_type . '_' . $settle_type;
                $condition = $this->STSelectType($key,true);

                foreach($condition as &$item){
                    $item = date('Y.m.d',strtotime($item));
                }

                $queryParams['HotelOrderQuery']['start_end'] = implode('-',$condition);
                $queryParams['HotelOrderQuery']['search_type'] = 3;

            }
            //订单部分
            $searchModel = new HotelOrderQuery();
            $dataProvider = $searchModel->search($queryParams,'finance');
            //统计部分
            $countInfo = $this->dynamicCompute($supplierModel,$show_type,$settle_type,$searchModel);
            return $this->render('finance',compact('supplierModel','accountModel','searchModel','dataProvider','countInfo','doneCount','waitCount','settle_type'));
        }else{
            return $this->render('finance',compact('supplierModel','accountModel','doneCount','waitCount','settle_type'));
        }

    }

    //账单结算 (需要 酒店供应商(财务) 权限)
    public function actionSettleBill(){
        $supplier = $this->findModel($this->supplier_id);
        //计算统计总量部分
        if($supplier->settle_type){
            $settle_type = 'month';
        }else{
            $settle_type = 'week';
        }
        $doneCount = $this->STGetTotalBill($supplier,'done',$settle_type);
        $doneCount->status = 1;

        $db = Yii::$app->db->beginTransaction();
        try {
            if(HotelSupplierService::settleLog($supplier,'status') && $doneCount->save() && $this->syncStatus($supplier,'status',1)){
                $db->commit();
                return $this->redirectAndMsg('/hotel-supplier/finance?id='.$this->supplier_id,'已结算');
            }else{
                $db->rollBack();
                return $this->redirectAndMsg('/hotel-supplier/finance?id='.$this->supplier_id,'服务器繁忙,请稍候再试');
            }
        }catch (\Exception $exception){
            $db->rollBack();
            return $this->redirectAndMsg('/hotel-supplier/finance?id='.$this->supplier_id,$exception->getMessage());
        }


    }
    //账单开票 (需要 酒店供应商(财务) 权限)
    public function actionInvoice(){
        $supplier = $this->findModel($this->supplier_id);

        //计算统计总量部分
        if($supplier->settle_type){
            $settle_type = 'month';
        }else{
            $settle_type = 'week';
        }
        $doneCount = $this->STGetTotalBill($supplier,'done',$settle_type);
        $doneCount->invoice = 1;

        $db = Yii::$app->db->beginTransaction();
        try {
            if(HotelSupplierService::settleLog($supplier,'invoice') && $doneCount->save() && $this->syncStatus($supplier,'invoice',1)){
                $db->commit();
                return $this->redirectAndMsg('/hotel-supplier/finance?id='.$this->supplier_id,'已开票');
            }else{
                $db->rollBack();
                return $this->redirectAndMsg('/hotel-supplier/finance?id='.$this->supplier_id,'服务器繁忙,请稍候再试');
            }
        }catch (\Exception $exception){
            $db->rollBack();
            return $this->redirectAndMsg('/hotel-supplier/finance?id='.$this->supplier_id,$exception->getMessage());
        }
    }

    /**
     * 同步结算/发票状态到供应商主表当中
     * @param int/HotelSupplier $supplier
     * @param string $type  类型仅限于 status/invoice 是结算还是开票
     * @param int $value  0代表未结算/未开票  1代表已结算/已开票
     * @return bool
     */
    protected function syncStatus($supplier,$type,$value){
        if(!in_array($type,['status','invoice'])){
            return false;
        }
        if(!($supplier instanceof HotelSupplier)){
            $supplier = $this->findModel($supplier);
        }
        $period = ($supplier->settle_type)? Helper::lastMonth(true,'ymd')[0] : Helper::lastWeek(true,'ymd')[0];
        $base_key = ['time' , 'status', 'invoice'];
        $base_value = [$period,0,0];
        $base_state = array_combine($base_key,$base_value);

        $old_state = ($supplier->invoice_status)? explode('_',$supplier->invoice_status) : $base_value;
        $old_state = array_combine($base_key,$old_state);

        if($old_state['time'] != $base_state['time']){
            $old_state = $base_state;
        }
        $old_state[$type] = (in_array($value,[0,1]))? $value : 1;

        $supplier->invoice_status = implode('_',$old_state);
        return $supplier->save();
    }

    /**
     * Finds the HotelSupplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HotelSupplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotelSupplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * ajax 请求城市三级联动接口
     */
    public function actionAjax(){

        if(!$this->request->isAjax){
            return $this->apiResponse(['code' => 400]);
        }


        $request = $this->request->post();

        if(empty($request['info'][$request['position']])){
            return $this->apiResponse(['code' => 401]);
        }

        switch ($request['position']){
            case 'country':
                $target = 'province';
                break;
            case 'province':
                $target = "city";
                break;
            default:
                $target = null;
        }

        if(is_null($target)){
            return $this->apiResponse(['code' => 402]);
        }

        $pid = $request['info'][$request['position']];
        try{
            $res = $this->getChildBlock($pid);
        }
        catch (\Exception $exception){
            Helper::dd($request);
        }

        $data = [
          'code' => 200,
          'target' => $target,
          'list' => $res
        ];

        return $this->apiResponse($data);
    }


    /**
     * 获取供应商基本信息模型
     * @return HotelSupplier|null|static
     */
    public function getModel(){
        $this->model = HotelSupplier::findOne($this->supplier_id);
        $this->is_new = false;

        if(is_null($this->model)){
            $this->model = new HotelSupplier();
            $this->is_new = true;
            if(!is_null($this->supplier_id)){
//                Yii::$app->session->setFlash('info','请先完善基本信息');
            }
        }

        return $this->model;
    }

    public function getAccountModel(){

        $model = HotelSupplierAccount::find()
            ->where(['supplier_id' => $this->supplier_id])
            ->one();

        if(is_null($model)){
            $model = new HotelSupplierAccount();
        }

        return $model;
    }

    /**
     * 检测录入供应商账户信息的时候是否已经存在供应商信息,如果没有则需要先不全供应商信息
     * @return bool
     */
    protected function checkHotelSupplier(){
        $id = $this->supplier_id;
        return is_null(HotelSupplier::findOne($id));
    }

    /**
     * 获取国家信息
     * @return array
     */
    public static function getcountry()
    {
        return Yii::$app->db->createCommand("select name,code from dt_city_seas where level = 0")->queryAll();
    }

    public static function getCity($limit = null){
        if($limit){
            return Yii::$app->db->createCommand("select name,code from dt_city_seas where level = 2 AND seas=0 LIMIT {$limit}")->queryAll();
        }
        return Yii::$app->db->createCommand("select name,code from dt_city_seas where level = 2 AND seas=0")->queryAll();
    }

    //根据城市编码找城市名
    public static function getCityName($code){
        if(empty($code)) return '全部城市';
        $model = DtCitySeas::findOne(['code'=>$code]);
        return $model->name;
    }


    //通过 ajax 模糊搜索城市列表
    public function actionSearchCity(){
        $request = $this->request->post('city_name',null);
        $request = trim($request);

        if(empty($request)){
            return $this->apiResponse([
                ['code' => null, 'name' => '城市不存在']
            ]);
        }

        $city = Yii::$app->db->createCommand("select name,code from dt_city_seas where level=2 AND name LIKE '%{$request}%' LIMIT 10")->queryAll();


        if(empty($city)){
            return $this->apiResponse([
                ['code' => null, 'name' => '城市不存在']
            ]);
        }else{
            return $this->apiResponse($city);
        }
    }

    /**
     * 获取省份/城市信息
     * @param $pid
     * @return array
     */
    public function getChildBlock($pid){
        return Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$pid}")->queryAll();
    }


    /**
     * 根据id 来查看省份和城市
     * @param $model
     * @return array
     */
    public function getCityAndProvince($model){
        $city = $model->city;
        $province = $model->province;
        $res = Yii::$app->db->createCommand("select name,code from dt_city_seas where code IN ({$city},{$province})")->queryAll();

        $res = ArrayHelper::map($res,'code','name');

        return $res;
    }


    /**
     * 重定向并弹出信息
     * @param $route
     * @param null $message
     * @param string $type
     * @return \yii\web\Response
     */
    public function redirectAndMsg($route,$message=null,$type='error'){
        if($message !== null){
//            Yii::$app->session->setFlash($type,$error);
            Yii::$app->session->setFlash('c_message',['type'=>$type,'message' => $message,'method'=>'alert']);
        }
        return $this->redirect($route);
    }

    /**
     * 直接弹出信息
     * @param string $type
     * @param $message
     * @param string $method
     */
    public function alertMsg($type="error",$message,$method='alert'){
        Yii::$app->session->setFlash('c_message',['type'=>$type,'message' => $message,'method'=>$method]);
    }
    /**
     * @账号管理
     * user:ys
     * time:2017/7/24 15:45
     */
    public function actionUser()
    {
        $this->getModel();
        if($this->is_new){
            return $this->redirectAndMsg('/hotel-supplier/add','请完善基本信息','');
        }

        $query = HotelUser::find()->where(['supplier_id' => $this->supplier_id]);
        $dataProvider = new ActiveDataProvider();
        $dataProvider->query = $query;


        return $this->render('user', [
            'dataProvider' => $dataProvider,
            'supplier_id'  => $this->supplier_id,
        ]);
    }
    /**
     * @账号添加ajax
     * time:2017/7/24
     * user:ys
     */
    public function actionUserAdd()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if (in_array('', $data)) {
                    throw new \Exception('post_null');
                }
                $old_mobile = HotelUser::find()
                    ->where(['mobile' => $data['mobile']])
                    ->select(['id'])
                    ->asArray()
                    ->scalar();
                if (!empty($old_mobile)) {
                    throw new \Exception('mobile_exist');
                }
                $pwd = self::RandomPwd();
                $password = self::EncryptionPwd($pwd);
                $post_data = [
                    'mobile' => $data['mobile'],
                    'name'   => $data['name'],
                    'job'    => $data['job'],
                    'email'  => $data['email'],
                    'last_time'   => date('Y-m-d H:i:s'),
                    'status'      => $data['status'],
                    'supplier_id' => $data['supplier_id'],
                    'password'    => $password,
                ];
                Yii::$app->db->createCommand()->insert('hotel_user', $post_data)->execute();
                $content = sprintf(ADD_USER, $data['mobile'], $pwd);
                if (!self::SendSms($data['mobile'], $content)) {
                    throw new \Exception('send_error');
                }
                $transaction->commit();
            }catch (\Exception $e) {
                $transaction->rollBack();
                $errMap = [
                    'post_null' => '提交数据不能为空！',
                    'supplier_id_null' => '提交数据异常！',
                    'mobile_exist' => '账号已存在！',
                    'send_error' => '提示短信发送失败！',
                ];
                return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'服务器异常！';
            }
            return 'success';
        } else {
            return '非法请求！';
        }
    }
    /**
     * @随机密码
     */
    private static function RandomPwd()
    {
        $count = 3;
        $str_data = [
            "a", "b", "c", "d", "e",
            "f", "g", "h", "i", "j",
            "k","l", "m", "n", "o",
            "p", "q", "r", "s", "t",
            "u", "v","w", "x", "y", "z"];
        $num_data = [0, 1, 2 ,3 ,4 ,5, 6, 7, 8, 9];
        $str = '';
        $num = '';
        for ($i = 0; $i < $count; $i++) {
            $str .= $str_data[array_rand($str_data, 1)];
            $num .= $num_data[array_rand($num_data, 1)];
        }
        $str_num = $str.$num;
        return $str_num;
    }
    /**
     * 酒店-用户 随机密码加密
     */
    private static function EncryptionPwd($pwd)
    {
        return sha1("EBooking".$pwd);
    }
    /**
     * @发送短信
     */
    private static function SendSms($mobile, $content)
    {
        $status = SmspushController::sendSms($mobile, $content);//国内
        return $status;
    }
    /**
     * @删除酒店Ebooking用户
     * time:2017/7/25
     * user:ys
     */
    public function actionDelUser()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            try{
                if (empty($id)) {
                    throw new \Exception('id_null');
                }
                if (!Yii::$app->db->createCommand()->delete('hotel_user', ['id' => $id])->execute()) {
                    throw new \Exception('sql_error');
                }
            }catch (\Exception $e) {
                $errMap = [
                    'id_null'   => '异常操作！',
                    'sql_error' => '服务器内部异常！',
                ];
                return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'服务器异常！';
            }
            return 'success';
        } else {
            return '非法请求！';
        }
    }
    /**
     * @重置密码
     * time:2017/7/25
     * user:ys
     */
    public function actionResetPwd()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if (empty($id)) {
                    throw new \Exception('post_data_null');
                }
                $sql = "SELECT `mobile` FROM `hotel_user` WHERE `id`=:id";
                $mobile = Yii::$app->db->createCommand($sql)
                    ->bindValues([':id' => $id])
                    ->queryScalar();
                if (empty($mobile)) {
                    throw new \Exception('mobile_abnormal');
                }
                $pwd = self::RandomPwd();
                $password = self::EncryptionPwd($pwd);
                $update_data = [
                    'password' => $password
                ];
                if (!Yii::$app->db->createCommand()->update('hotel_user', $update_data, ['mobile' => $mobile])->execute()) {
                    throw new \Exception('sql_handle_abnormal');
                }
                $content = sprintf(EDIT_PWD, $pwd);
                if (!SmspushController::sendSms($mobile, $content)) {
                    throw new \Exception('send_error');
                }
                $transaction->commit();
            }catch (\Exception $e) {
                $transaction->rollBack();
                $errMap = [
                    'post_data_null'      => '异常操作！',
                    'mobile_abnormal'     => '账号异常！',
                    'sql_handle_abnormal' => '服务器内部异常！',
                    'send_error'       => '短信发送失败！',
                ];
                return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'服务器异常！';
            }
            return 'success';
        } else {
            return '异常请求！';
        }
    }
    /**
     * @编辑填充数据
     * time:2017/7/25
     * user:ys
     */
    public function actionEditData()
    {
        $id = Yii::$app->request->post('data')['id'];
        if (Yii::$app->request->isAjax) {
            try{
                if (empty($id)) {
                    throw new \Exception('post_data_null');
                }
                $sql = "SELECT * FROM `hotel_user` WHERE `id`=:id";
                $user_info = Yii::$app->db->createCommand($sql)->bindValues([':id' => $id])->queryOne();
                if (empty($user_info)) {
                    throw new \Exception('user_info_null');
                }
            }catch (\Exception $e) {
                $errMap = [
                    'post_data_null' => '异常操作！',
                    'user_info_null' => '数据信息异常！',
                ];
                return json_encode(isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'服务器异常！');
            }
            $user_info['code'] = 'success';
            return json_encode($user_info);
        } else {
            return '非法请求！';
        }
    }
    /**
     * @修改用户信息
     * time:2017/7/25
     * user:ys
     */
    public function actionEditUser()
    {
        $data = Yii::$app->request->post('data');
        if (Yii::$app->request->isAjax) {
            try{
                if (in_array('', $data)) {
                    throw new \Exception('post_data_null');
                }
                $update_data = [
                    'mobile' => $data['mobile'],
                    'name'     => $data['name'],
                    'job'      => $data['job'],
                    'email'    => $data['email'],
                    'status'   => $data['status'],
                ];
                if (!Yii::$app->db->createCommand()->update('hotel_user', $update_data, ['id' => $data['id']])->execute()) {
                    throw new \Exception('sql_handle_abnormal');
                }
            }catch (\Exception $e) {
                $errMap = [
                    'post_data_null'      => '提交数据不能为空',
                    'sql_handle_abnormal' => '服务器内部异常！',
                ];
                return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'服务器异常！';
            }
            return 'success';
        } else {
            return '非法请求！';
        }
    }
    /**
     * @财务结算-新开
     */
    public function actionSettlement()
    {
        $this->getModel();
        if($this->is_new){
            return $this->redirectAndMsg('/hotel-supplier/add','请完善基本信息','');
        }
        //供应商账户信息部分
        $accountModel = HotelSupplierAccount::findOne(['supplier_id' => $this->supplier_id]);
        if (is_null($accountModel)){
            return $this->redirectAndMsg('/hotel-supplier/account?id='.$this->supplier_id,'请先完善账号信息');
        }
        $searchModel = new HotelSupplierSettlementQuery();
        $searchModel['supplier_id'] = $this->supplier_id;
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($queryParams);
//        $account_info = self::AccountData($this->supplier_id);//账户信息
        $hotel_select = self::HotelSelect($this->supplier_id);//酒店筛选
        $top_total = self::SettleTotalPrice(NULL, $this->supplier_id);
        $top_settle = self::SettlementPrice(NULL, $this->supplier_id);
        $hotel_info = self::ObjToArray($dataProvider->getModels());
        $settle_info = self::HotelSettlePrice($hotel_info);
        if (empty($dataProvider->getModels())) {
            $settle_info['total'] = 0;
            $settle_info['settle'] = 0;
        }
//        echo '<pre>';
//        print_r($dataProvider->getModels());die;
        return $this->render('settle', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'supplier_id'  => $this->supplier_id,
//            'account_info' => $account_info,//账户信息
            'hotel_select' => $hotel_select,
            'top_total'    => $top_total,//顶部总价
            'top_settle'   => $top_settle,//顶部已结算
            'hotel_price'  => $settle_info,//酒店总价
        ]);

    }
    /**
     * @account账户信息
     */
    public static function AccountData($supplier_id)
    {
        $sql = "SELECT * FROM `hotel_supplier_account` WHERE `supplier_id`=:supplier_id";
        $account_data = Yii::$app->db->createCommand($sql)
            ->bindValues([':supplier_id' => $supplier_id])
            ->queryOne();
        return $account_data;
    }
    /**
     * @account账户信息 V316（内容更改）
     */
    public function actionLookAccountData()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data', '');
            if (empty($data) || empty($data['id'])) {
                return $this->JsonReturn(1, '请求异常！');
            }
            $id = $data['id'];//结算表ID
            $settle_info = HotelSupplierSettlement::find()
                ->where(['id' => $id])
                ->select(['settle_obj', 'hotel_id', 'supplier_id'])
                ->asArray()
                ->one();
            $settle_obj = $settle_info['settle_obj'];
            if ($settle_obj === '0') {//结算至供应商，查询supplier_id字段
                $sql = "SELECT * FROM `hotel_supplier_account` WHERE `supplier_id`=:supplier_id";
                $account_data = Yii::$app->db->createCommand($sql)
                    ->bindValues([':supplier_id' => $settle_info['supplier_id']])
                    ->queryOne();
            } else {//结算至酒店，查询hotel_id字段
                $sql = "SELECT * FROM `hotel_supplier_account` WHERE `hotel_id`=:hotel_id";
                $account_data = Yii::$app->db->createCommand($sql)
                    ->bindValues([':hotel_id' => $settle_info['hotel_id']])
                    ->queryOne();
            }
            //判定打款的账号信息是否存在
            if (empty($account_data)) {
                return $this->JsonReturn(1, '账单信息异常！');
            }
            //账户类型文案化
            if (isset($account_data["type"]) && $account_data["type"] != 0) {
                $account_data['type'] = Yii::$app->params["hotel_supplier_account_type"][$account_data["type"]];
            }
            return $this->JsonReturn(0,$account_data);
        } else {
            return $this->JsonReturn(1, '非法请求！');
        }
    }
    /**
     * @酒店筛选
     */
    public static function HotelSelect($supplier_id)
    {
        $sql = "SELECT `hotel_id`,`complete_name` FROM `hotel_supplier_settlement` LEFT JOIN `hotel` ON `hotel_id`=hotel.id WHERE hotel_supplier_settlement.supplier_id=:supplier_id";
        $settle_info = Yii::$app->db->createCommand($sql)
            ->bindValues([':supplier_id' => $supplier_id])
            ->queryAll();
        if (empty($settle_info)) {
            return NULL;
        }
        $id_arr = [];
        foreach ($settle_info as $val) {
            $id_arr[$val['hotel_id']] = $val['complete_name'];
        }
        return $id_arr;
    }
    /**
     * @结算账目信息(总价)
     */
    public static function SettleTotalPrice($hotel_id = NULL, $supplier_id = NULL)
    {
        $total_price = HotelSupplierSettlement::find()
            ->where(['supplier_id' => $supplier_id])
            ->sum('total');
        return $total_price;
    }
    /**
     * @结算账目信息(已结算)
     */
    public static function SettlementPrice($hotel_id = NULL, $supplier_id = NULL)
    {
        $total_price = HotelSupplierSettlement::find()
            ->where(['supplier_id' => $supplier_id])
            ->andWhere(['status' => 1])
            ->sum('total');
        return $total_price;
    }
    /**
     * @搜索结算数据 （对象转数组）
     */
    private static function ObjToArray($data)
    {
        $obj = (array)$data;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = self::ObjToArray($v);
            }
        }
        return $obj;
    }
    /**
     * @搜索结算总价-结算价
     */
    public static function HotelSettlePrice($hotel_info)
    {
        if (empty($hotel_info)) {
            return NULL;
        }
        $data['total'] = 0;
        $data['settle'] = 0;
        foreach ($hotel_info as $value) {
            if ($value['status'] == 1) {//已结算
                $data['settle'] += $value['total'];
            }
            $data['total'] += $value['total'];
        }
        return $data;
    }
}
