<?php

namespace backend\controllers;

use backend\models\DtCitySeas;
use backend\models\Hotel;
use backend\models\HotelHouse;
use backend\models\HotelImg;
use backend\models\HotelQuery;
use backend\models\HotelSupplierAccount;
use backend\models\HotelSupplierQuery;
use backend\models\SearchSql;
use backend\models\Submit;
use backend\service\CommonService;
use backend\service\HotelService;
use backend\service\RegionService;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * @author: fuyanfei
 * @date  : 2017年4月18日13:26:25
 * @info  : 酒店管理
 * HotelControlle implements the CRUD actions for Hotel model.
 */
class HotelController extends Controller
{
    public $enableCsrfValidation = false;

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
     * 酒店列表
     */
    public function actionIndex()
    {
        //实例化HotelQuery
        $searchModel = new HotelQuery();
        //获取酒店model
        //$searchModel->admin_id=Yii::$app->user->identity->getId();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'method' => 'index',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 新增酒店基本信息
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Hotel();
        if ($model->load(Yii::$app->request->post())) {
            //判断是否手动填写了经纬度，并且经纬度填写格式正确，才会保存入库
            if (!empty(Yii::$app->request->post()['Hotel']['Lati_Long_tude']) && strpos(Yii::$app->request->post()['Hotel']['Lati_Long_tude'], ',') !== false) {
                $Lati_Long_tude_data = explode(',', Yii::$app->request->post()['Hotel']['Lati_Long_tude']);
                $model->longitude = $Lati_Long_tude_data[0];//经度
                $model->latitude = $Lati_Long_tude_data[1];//纬度
            }
            //酒店简介文本域换行问题
            $model->introduction = str_replace("\n", "<br>", Yii::$app->request->post()['Hotel']['introduction']);
            //酒店特色文本域换行问题
            $model->feature = str_replace("\n", "<br>", Yii::$app->request->post()['Hotel']['feature']);
            //添加人
            $model->admin_id = Yii::$app->user->identity->getId();
            $model->create_time = date("Y-m-d H:i:s", time());
            $trans = Yii::$app->db->beginTransaction();
            try {
                //添加酒店信息
                $model->save();
                //添加酒店审核日志信息
                $res = Yii::$app->db->createCommand("INSERT INTO hotel_check_logs(hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                    ->bindValue(":hotel_id", $model->id)
                    ->bindValue(":before_status", 0)
                    ->bindValue(":after_status", 0)
                    ->bindValue(":remarks", "新增酒店信息提交审核")
                    ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                    ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                    ->execute();
                Yii::$app->session->setFlash('success', '添加成功');
                $trans->commit();
                return $this->redirect(['hotel-account', 'id' => $model->id]);
            } catch (Exception $e) {
                $trans->rollBack();
                Yii::$app->session->setFlash('errors', '添加失败');
            }
        }
        //获取中国的所有省份
        $provice = RegionService::getRegion(1, 10001);
        return $this->render('add', [
            'model' => $model,
            'provice' => $provice,
        ]);
    }

    /**
     * 编辑酒店信息
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionUpdate()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }
        //查询当前的酒店基本信息
        $model = Hotel::find()->where(['id' => $id])->one();
        //获取当前酒店的审核状态
        $before_status = $model->check_status;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $trans = Yii::$app->db->beginTransaction();
                try {
                    //判断是否手动填写了经纬度，并且经纬度填写格式正确，才会保存入库
                    if (!empty(Yii::$app->request->post()['Hotel']['Lati_Long_tude']) && strpos(Yii::$app->request->post()['Hotel']['Lati_Long_tude'], ',') !== false) {
                        $Lati_Long_tude_data = explode(',', Yii::$app->request->post()['Hotel']['Lati_Long_tude']);
                        $model->longitude = $Lati_Long_tude_data[0];//经度
                        $model->latitude = $Lati_Long_tude_data[1];//纬度
                    }
                    //酒店简介文本域换行问题
                    $model->introduction = str_replace("\n", "<br>", Yii::$app->request->post()['Hotel']['introduction']);
                    //酒店特色文本域换行问题
                    $model->feature = str_replace("\n", "<br>", Yii::$app->request->post()['Hotel']['feature']);
                    //添加人
                    $model->admin_id = Yii::$app->user->identity->getId();
                    //添加时间
                    $model->create_time = date("Y-m-d H:i:s", time());
                    //只要编辑酒店信息，审核状态改为待审核
                    //$model->check_status = 0;
                    $res = $model->save(false);
                    //添加审核日志信息
                    /*Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                        ->bindValue(":hotel_id", $id)
                        ->bindValue(":before_status", $before_status)  //修改之前待审核状态
                        ->bindValue(":after_status", 0)                //修改时候的审核状态
                        ->bindValue(":remarks", "修改酒店基本信息，提交审核")
                        ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                        ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                        ->execute();*/
                    $trans->commit();
                    return $this->redirectAndMsg(['hotel-account', 'id' => $model->id], '修改成功', 'success');
                } catch (Exception $e) {
                    $trans->rollBack();

                    Yii::$app->session->setFlash('errors', '修改失败');
                }
            }
        }
        //根据国家，获取所有的省
        $provice = RegionService::getRegion(1, 10001);
        //根据省  ，获取所有的城市
        $city = RegionService::getRegion(2, $model->province);
        //根据城市，获取所有的区县
        $area = RegionService::getRegion(3, $model->city);
        $model->introduction = str_replace("<br>", "\n", $model->introduction);
        //酒店特色文本域换行问题
        $model->feature = str_replace("<br>", "\n", $model->feature);
        return $this->render('update', [
            'model' => $model,
            'provice' => $provice,
            'city' => $city,
            'area' => $area,
        ]);
    }

    /**
     * @酒店2.1 编辑账户信息
     * admin:ys
     * time:201/11/3
     */
    public function actionHotelAccount()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];//此id值是酒店id，不是供应商id
        } else {
            return $this->redirect(['error']);
        }
        //判断是否存在表单提交事件，此时对应的操作为（修改酒店结算对象settle_obj（0结算至供应商 1结算至酒店），修改酒店账户信息或者添加酒店账户信息）
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post()['HotelSupplierAccount'];
//            dd($params);
            //判断用户选择的要结算时的打款对象
            if ($params['account_type'] === '0') {//选择打款至酒店供应商
                $update_data = [
                    'update_time' => date('Y-m-d H:i:s'),//修改时间
                    'settle_obj'  => $params['account_type'],//结算对象（0.供应商  1.酒店）
                ];
                $update_status = SearchSql::_UpdateSqlExecute('hotel', $update_data, ['id' => $params['hotel_id']]);
                if ($update_status) {//修改成功，跳转至酒店政策页面
                    return $this->redirectAndMsg(['two', 'id' => $params['hotel_id']], '修改成功', 'success');
                } else {//修改失败，回到原页
                    Yii::$app->session->setFlash('errors', '修改失败');
                }
            }
            //---用户选择打款至酒店账户---事务修改（修改hotel表settle_obj字段，更新hotel_supplier_account表信息）
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //修改hotel表settle_obj字段（0.打款至供应商 1.打款至酒店）
                $update_data = [
                    'update_time' => date('Y-m-d H:i:s'),//修改时间
                    'settle_obj'  => $params['account_type'],//结算对象（0.供应商  1.酒店）
                ];
                $update_status = SearchSql::_UpdateSqlExecute('hotel', $update_data, ['id' => $params['hotel_id']]);
                if (!$update_status) {//修改失败，抛出异常
                    throw new \Exception('update_hotel_settle_obj_abnormal');
                }
                //更新hotel_supplier_account表信息（新增或者修改酒店账户信息）
                if ($params['hotel_account_note'] === 'yes') {//存在账户信息，因此为修改酒店账户信息
                    $hotel_account_model = HotelSupplierAccount::find()
                        ->where(['hotel_id' => $params['hotel_id']])//酒店ID
                        ->andWhere(['account_type' => 1])//账户类型，限定为酒店账户
                        ->one();
                } else {//不存在账户信息，此时为添加账户信息
                    $hotel_account_model = new HotelSupplierAccount();
                    $hotel_account_model->supplier_id = 0;//供应闪ID
                    $hotel_account_model->hotel_id = $params['hotel_id'];//酒店ID
                    $hotel_account_model->account_type = 1;//账户类型为酒店账户（0.供应商 1.酒店）
                }
                //需要更新的数据信息
                $hotel_account_model->user_name = $params['user_name'];//财务联系人
                $hotel_account_model->mobile = $params['mobile'];//联系人手机
                $hotel_account_model->email = $params['email'];//邮箱
                $hotel_account_model->bank_name = $params['bank_name'];//银行名称
                $hotel_account_model->bank_detail = $params['bank_detail'];//开户行名称
                $hotel_account_model->account_name = $params['account_name'];//户名
                $hotel_account_model->account_number = $params['account_number'];//银行账号
                $hotel_account_model->alipay_number = $params['alipay_number'];//支付宝账号
                $hotel_account_model->type = $params['type'];//账户类型（1=>对公账户 2=>对私账户）
//                $hotel_account_model->save(false);
                if (!$hotel_account_model->save(false)) {//添加或者修改酒店账户信息失败
                    throw new \Exception('reset_hotel_settle_account_info_abnormal');
                }
                $transaction->commit();
                return $this->redirectAndMsg(['two', 'id' => $params['hotel_id']], '修改成功', 'success');
            } catch (\Exception $e) {
                $transaction->rollBack();
//                $errorMsg = $e->getMessage();
//                dd($errorMsg);
                Yii::$app->session->setFlash('errors', '修改失败');
            }
        }
        //获取酒店设定原先设置的打款对象（0酒店供应商 1酒店）
        $settle_obj = Hotel::find()
            ->where(['id' => $id])
            ->select([
                'settle_obj'
            ])//结算时的打款对象
            ->scalar();
        //获取酒店账户信息
        $model = HotelSupplierAccount::find()
            ->where(['hotel_id' => $id])
            ->andWhere(['account_type' => 1])//限定酒店账号信息，所以写死搜索条件为1 （0.供应商  1.酒店）
            ->one();
        //设定一个值，作为判定酒店账户是已存在的，在后续操作中需要修改，还是说酒店账户是不存在的，后续需要添加
        $hotel_account_note = 'yes';
        if (empty($model)) {//该酒店打款至酒店供应商，没有设置酒店账户信息
            //设置null酒店账户信息
            $model = new HotelSupplierAccount();
            $model->hotel_id = $id;
            $hotel_account_note = 'no';
        }
        $model->account_type = $settle_obj;
        return $this->render('account', [
            'hotel_account_note' => $hotel_account_note,
            'model'              => $model,
            'settle_obj'         => $settle_obj,
        ]);


    }
    /**
     * 编辑酒店政策信息
     * @return string|\yii\web\Response
     */
    public function actionTwo()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }
        //查询当前的酒店基本信息
        $model = Hotel::find()->where(['id' => $id])->one();
        //$before_status = $model->check_status;
        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post()['Hotel'];
            //校验政策信息
            $result_info = self::TestTwoPostData($params);
            $status = $result_info['judge_status'];
            //校验通过，更新post信息
            $params = $result_info;
            //校验不通过
            if (!$status) {
                if ($model->prompt != "") {
                    $model->prompt = str_replace("<br>", "\n", $model->prompt);
                }
                return $this->render('two', [
                    'model' => $model,
                    'error_note' => $result_info['error_note'],
                    'params'     => $params
                ]);
            }
//            dd($params);
            $trans = Yii::$app->db->beginTransaction();
            try {
                //发票提示文本域换行问题
                $prompt = str_replace("\n", "<br>", Yii::$app->request->post()['Hotel']['prompt']);
                $update_data = [
                    'in_time'      => $params['in_time'],
                    'out_time'     => $params['out_time'],
                    'sale_time'    => $params['sale_time'],
                    'prompt'       => $prompt,
                    'hotel_rule'   => $params['hotel_rule'],//酒店规则-其他
                    'hotel_tips'   => $params['hotel_tips'],//酒店提示
                    'child_in'     => ($params['child_in'] == 1 ? 0 : 1),//是否接受儿童入住  0不接受 1接受
                    'child_charge' => $params['child_charge'],//儿童入住是否收费   0不收费 1收费
                    'child_price'  => $params['child_price'],//儿童收费价格
                    'pet_in'       => ($params['pet_in'] == 1 ? 0 : 1),//是否接受宠物  0-不接受 1-接受
                    'buffet_break' => $params['buffet_break'],//是否自助早餐  0-是 1-不是
                    'buffet_break_price' => $params['buffet_break_price'],//自助早餐价格
                ];
                SearchSql::_UpdateSqlExecute('hotel', $update_data ,['id' => $model->id]);


//                $result = Yii::$app->db->createCommand("UPDATE hotel SET in_time=:in_time,out_time=:out_time,sale_time=:sale_time,prompt=:prompt WHERE id=:id")
//                    ->bindValue(":in_time", $params['in_time'])
//                    ->bindValue(":out_time", $params['out_time'])
//                    ->bindValue(":sale_time", $params['sale_time'])
//                    ->bindValue(":prompt", $prompt)
//                    //->bindValue(":check_status", 0)
//                    ->bindValue(":id", $model->id)
//                    ->execute();

                //添加审核信息
                /* Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                     ->bindValue(":hotel_id", $id)
                     ->bindValue(":before_status", $before_status)
                     ->bindValue(":after_status", 0)
                     ->bindValue(":remarks", "修改酒店政策信息，提交审核")
                     ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                     ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                     ->execute();*/
                $trans->commit();

                return $this->redirectAndMsg(['three', 'id' => $model->id], '操作成功', 'success');
            } catch (Exception $e) {
                $trans->rollBack();
                Yii::$app->session->setFlash('errors', '添加失败');
            }
        }
        if ($model->prompt != "") {
            $model->prompt = str_replace("<br>", "\n", $model->prompt);
        }
        //查询相关城市Hotel::find()->where(['id' => $id])->one();
        $city = DtCitySeas::findOne($model->city);
        return $this->render('two', [
            'model' => $model,
            'city' => $city,
        ]);
    }
    /**
     * @用城市码换取城市名
     * $code : 城市码
     */
    public static function CityCodeToName($city_code)
    {
        $city_name = DtCitySeas::find()
            ->where(['code' => $city_code])
            ->select(['name'])
            ->scalar();
        return $city_name;
    }
    /**
     * @验证酒店政策-酒店政策信息
     * @$params post传递相关参数
     */
    public static function TestTwoPostData($params)
    {
        //勾选儿童收费
        if (isset($params['child_charge']) || !empty($params['child_charge'])) {
            //没有输入费用价格
            if (empty($params['child_price'])) {
                $params['judge_status'] = false;
                $params['error_note'] = 'child_charge';
                return $params;
            }
        } else {
            $params['child_charge'] = 0;//0不收费 1收费
            $params['child_price'] = 0;
        }
        //勾选自助早餐
        if (isset($params['buffet_break']) || !empty($params['buffet_break'])) {
            //没有输入早餐价格
            if (empty($params['buffet_break_price'])) {
                $params['judge_status'] = false;
                $params['error_note'] = 'buffet_break';
                return $params;
            }
        } else {
            $params['buffet_break'] = 0;//0是  1不是
            $params['buffet_break_price'] = 0;
        }
        //勾选 其他酒店政策
        if (isset($params['hotel_rule_note']) || !empty($params['hotel_rule_note'])) {
            //没有输入其他酒店政策
            if (empty($params['hotel_rule'])) {
                $params['judge_status'] = false;
                $params['error_note'] = 'hotel_rule_note';
                return $params;
            }
        } else {
            $params['hotel_rule'] = '';
        }
        $params['judge_status'] = true;
        return $params;
    }

    /**
     * 编辑酒店服务设施信息
     * @return string|\yii\web\Response
     */
    public function actionThree()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }
        //查询当前的酒店基本信息
        $model = Hotel::find()->where(['id' => $id])->one();
        $before_status = $model->check_status;
        //判断是不是第三步提交的
        if (Yii::$app->request->isPost) {
            $facilities = [];
            $trans = Yii::$app->db->beginTransaction();
            try {
                //删除原先的酒店设施
                $delSql = "DELETE FROM hotel_service_facilities WHERE hotel_id = " . Yii::$app->request->post()['id'];
                $delRes = Yii::$app->db->createCommand($delSql)->execute();

                //批量添加数据
                foreach (Yii::$app->request->post()['facilities'] as $key => $val) {
                    $v['hotel_id'] = Yii::$app->request->post()['id'];
                    $v['facilities_id'] = $val;
                    $facilities[] = $v;
                }
                $insertRes = Yii::$app->db->createCommand()->batchInsert('hotel_service_facilities', ['hotel_id', 'facilities_id'], $facilities)->execute();

                /*//修改酒店状态
                Yii::$app->db->createCommand("UPDATE hotel set check_status = 0 where id = :id")
                    ->bindValue(":id", $id)
                    ->execute();

                //添加审核信息
                Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                    ->bindValue(":hotel_id", $id)
                    ->bindValue(":before_status", $before_status)
                    ->bindValue(":after_status", 0)
                    ->bindValue(":remarks", "修改酒店服务设施，提交审核")
                    ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                    ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                    ->execute();*/
                $trans->commit();

                return $this->redirectAndMsg(['four', 'id' => $model->id], '操作成功', 'success');
            } catch (Exception $e) {
                Yii::$app->session->setFlash('errors', '添加失败');
                $trans->rollBack();
            }
        }

        $ser_fac = Yii::$app->db->createCommand("SELECT * FROM hotel_service_facilities WHERE hotel_id = " . $id)->queryAll();
        $res = [];
        if (!empty($ser_fac)) {
            foreach ($ser_fac as $key => $val) {
                $res[] = $val['facilities_id'];
            }
        }

        //获取所有的设施服务
        $facilities = HotelService::getAllFacilities();
        return $this->render('three', [
            'model' => $model,
            'facilities' => $facilities,
            'ser_fac' => $res,
        ]);

    }
    /**
     * 编辑酒店服务设施信息
     * @return string|\yii\web\Response
     */
    public function actionFour()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }
        $sql = "SELECT id,name,breakfast,room_size,type,refund_type,cover_img FROM hotel_house WHERE hotel_id = :hotel_id and status != 3";
        $house = Yii::$app->db->createCommand($sql)->bindValue(":hotel_id", $id)->queryAll();

        return $this->render('four', [
            'house' => $house,
            'id' => $id,
        ]);
    }

    /**
     * 添加房型
     * @return string
     */
    public function actionAddHouse()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }
        //实例化model
        $model = new HotelHouse();
        $hotelModel = Hotel::findOne($id);
        //$before_status = $hotelModel->check_status;
        if ($model->load(Yii::$app->request->post())) {
            $model->type = Yii::$app->request->post()['type'];
            $model->bed_num = Yii::$app->request->post()['bed_num'];
            $model->bed_width = Yii::$app->request->post()['bed_width'];
            if (Yii::$app->request->post()['floor_type'] !== '') {
                $model->floor_type = Yii::$app->request->post()['floor_type'];
            }
            $model->floor = Yii::$app->request->post()['floor'];
            //选择其他床型时
            if ($model->type == 11) {
                $model->type_other_name = Yii::$app->request->post()['other_bed_type'];
            }
            //床型信息更改
            if ($model->type == 2) {//如果床型选择的是大床或双床，对选择的数据进行处理
                $model->bed_num = Yii::$app->request->post()['bed_num2'];//双床个数
                $model->bed_width = Yii::$app->request->post()['bed_width2'];//双床宽度
                $model->bed_single_num = Yii::$app->request->post()['bed_num1'];//大床个数
                $model->bed_single_width = Yii::$app->request->post()['bed_width1'];//大床宽度
            }
            $trans = Yii::$app->db->beginTransaction();
            try {
                //$pic_desc = implode(",", Yii::$app->request->post()['pic_desc']);
                $pic = implode(",", Yii::$app->request->post()['pic']);
                //$model->pic_desc = $pic_desc;
                $model->pic_desc = "";
                $model->pic = $pic;

                if (Yii::$app->request->post()['cover_img'] == "")
                    $model->cover_img = Yii::$app->request->post()['pic'][0];
                else
                    $model->cover_img = Yii::$app->request->post()['cover_img'];
                $model->hotel_id = $id;
                $res = $model->save();
                /*//修改酒店状态
                Yii::$app->db->createCommand("UPDATE hotel set check_status = 0 where id = :id")
                    ->bindValue(":id", $id)
                    ->execute();

                //添加审核信息
                Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                    ->bindValue(":hotel_id", $id)
                    ->bindValue(":before_status", $before_status)
                    ->bindValue(":after_status", 0)
                    ->bindValue(":remarks", "添加酒店房型，提交审核")
                    ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                    ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                    ->execute();*/

                $trans->commit();
                return $this->redirectAndMsg(['update-house', 'house_id' => $model->id], '添加成功', 'success');

            } catch (Exception $e) {
                //dump($model->errors);exit;
                $trans->rollBack();
                Yii::$app->session->setFlash('errors', '添加失败');
            }
        }

        return $this->render('add-house', [
            'model' => $model,
            'id' => $id,
        ]);
    }

    /**
     * 修改房型
     * @return string|\yii\web\Response
     */
    public function actionUpdateHouse()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['house_id'])) {
            $house_id = Yii::$app->request->get()['house_id'];
        } else {
            return $this->redirect(['error']);
        }
        //实例化model
        $model = HotelHouse::find()->where(['id' => $house_id])->one();
        $picArr = [];
        if ($model->pic != "") {
            $picArr = explode(",", $model->pic);
        }
        $hotelModel = Hotel::findOne($model->hotel_id);
        //$before_status = $hotelModel->check_status;
        if ($model->load(Yii::$app->request->post())) {
//            dd(Yii::$app->request->post());
            $model->type = Yii::$app->request->post()['type'];
            $model->bed_num = Yii::$app->request->post()['bed_num'];
            $model->bed_width = Yii::$app->request->post()['bed_width'];
            $model->floor_type = Yii::$app->request->post()['floor_type'] === '' ? null: Yii::$app->request->post()['floor_type'];
            $model->floor = Yii::$app->request->post()['floor'];
            //选择其他床型时
            if ($model->type == 11) {
                $model->type_other_name = Yii::$app->request->post()['other_bed_type'];
            }
            //床型信息更改
            if ($model->type == 2) {//如果床型选择的是大床或双床，对选择的数据进行处理
                $model->bed_num = Yii::$app->request->post()['bed_num2'];//双床个数
                $model->bed_width = Yii::$app->request->post()['bed_width2'];//双床宽度
                $model->bed_single_num = Yii::$app->request->post()['bed_num1'];//大床个数
                $model->bed_single_width = Yii::$app->request->post()['bed_width1'];//大床宽度
            }
            $trans = Yii::$app->db->beginTransaction();
            try {
                $picStr = "";
                //房型图片
                if (!empty(Yii::$app->request->post()['pic'])) {
                    $picStr = implode(",", Yii::$app->request->post()['pic']);
                }
                $model->pic = $picStr;
                //首图
                if (Yii::$app->request->post()['cover_img'] == "")
                    $model->cover_img = Yii::$app->request->post()['pic'][0];
                else
                    $model->cover_img = Yii::$app->request->post()['cover_img'];
                //取消政策
                if ($model->refund_type != 0) {
                    $model->refund_time = 0;
                }
                $res = $model->save();
                /*//修改酒店状态
                Yii::$app->db->createCommand("UPDATE hotel set check_status = 0 where id = :id")
                    ->bindValue(":id", $model->hotel_id)
                    ->execute();
                //添加审核信息
                Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                    ->bindValue(":hotel_id", $model->hotel_id)
                    ->bindValue(":before_status", $before_status)
                    ->bindValue(":after_status", 0)
                    ->bindValue(":remarks", "修改酒店房型，提交审核")
                    ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                    ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                    ->execute();*/
                $trans->commit();
                Yii::$app->session->setFlash('msg', '修改成功');
                return $this->redirectAndMsg(['update-house', 'house_id' => $house_id], '修改成功', 'success');
            } catch (Exception $e) {
                $trans->rollBack();
                Yii::$app->session->setFlash('errors', '修改失败');
            }
        }
        return $this->render('update-house', [
            'model' => $model,
            'picArr' => $picArr,
            'cover_img' => $model->cover_img,
        ]);
    }

    /**
     * 修改房型状态为暂停售卖。
     * @throws \yii\db\Exception
     */
    public function actionUpdateStatus()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_house_id = Yii::$app->request->post('hotel_house_id');
            $hotel_id = Yii::$app->request->post('hotel_id');
            $status = Yii::$app->request->post('status');
            $trans = Yii::$app->db->beginTransaction();
            try {
                //修改房型状态为暂停售卖
                $res = Yii::$app->db->createCommand("update hotel_house set status=:status WHERE id=:id")
                    ->bindValue(":status", $status)
                    ->bindValue(":id", $hotel_house_id)
                    ->execute();
                //修改当前房型状态的价格日历表，所有此房型的库存状态为关闭状态，，库存为0，库存类型为没有设置库存
                /*Yii::$app->db->createCommand("update hotel_date_status set status = :status,stock = :stock,type = :type where hotel_id = :hotel_id and hotel_house_id = :hotel_house_id")
                    ->bindValue("status",0)
                    ->bindValue(":stock",0)
                    ->bindValue(":type",0)
                    ->bindValue(":hotel_id",$hotel_id)
                    ->bindValue(":hotel_house_id",$hotel_house_id)
                    ->execute();*/
                /*if($status==0){
                    //将房型状态修改为暂停售卖时，要删除价格日历表中对此房型的库存状态设置。
                    Yii::$app->db->createCommand("DELETE FROM hotel_date_status WHERE hotel_house_id=:hotel_house_id AND hotel_id=:hotel_id")
                        ->bindValue(":hotel_id", $hotel_id)
                        ->bindValue(":hotel_house_id", $hotel_house_id)
                        ->execute();
                    //将房型状态修改为暂停售卖时，要删除价格日历表中对此房型的价格设置。
                    Yii::$app->db->createCommand("DELETE FROM hotel_date_price WHERE hotel_house_id=:hotel_house_id AND hotel_id=:hotel_id")
                        ->bindValue(":hotel_id", $hotel_id)
                        ->bindValue(":hotel_house_id", $hotel_house_id)
                        ->execute();
                }*/
                $trans->commit();
                echo 1;

            } catch (Exception $e) {
                $trans->rollBack();
                echo -1;
            }
        }
    }

    /**
     * 设置酒店房型头图
     * @throws \yii\db\Exception
     */
    public function actionSetTitlePic()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_house_id = Yii::$app->request->post('hotel_house_id');
            $title_pic = Yii::$app->request->post('title_pic');
            if (empty($hotel_house_id) || empty($title_pic)) {
                echo -1;
                die;
            }
            echo Yii::$app->db->createCommand("update hotel_house set cover_img=:cover_img WHERE id=:id")
                ->bindValue(":cover_img", $title_pic)
                ->bindValue(":id", $hotel_house_id)
                ->execute();
            die;
        }
    }

    /**
     * 设置首图为空
     * @throws \yii\db\Exception
     */
    public function actionDelTitlePic()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_house_id = Yii::$app->request->post('hotel_house_id');
            $res = Yii::$app->db->createCommand("update hotel_house set cover_img='' WHERE id=:id")->bindValue(":id", $hotel_house_id)->execute();
            dump($res);exit;
            if($res>=0)
                echo 1;
        }
    }


    //设置房价
    public function actionSetPrice()
    {
        try {
            $hotel_id = Yii::$app->request->get('hotel_id');
            $session_str = 'hotel_' . $hotel_id;
            $start_date = $_SESSION[$session_str] ? $_SESSION[$session_str] : date('Y-m-d', time());
            $end_date = date("Y-m-d", strtotime("+1 months", strtotime($start_date)));
            $date = CommonService::getDate($start_date, $end_date);
            $price_end_date = date("Y-m-d", strtotime("+8 day", strtotime($start_date)));
            $price_date = CommonService::getDate($start_date, $price_end_date);
            $hotel_house = Yii::$app->db->createCommand("select id,name,hotel_id from hotel_house WHERE hotel_id=$hotel_id")->queryAll();
            $hotel_house1 = $hotel_house;
            foreach ($hotel_house as $k => $v) {
                foreach ($date as $kk => $vv) {
                    $stock_data = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vv}'")->queryOne();
                    if (!$stock_data) {
                        $hotel_house[$k]['stock'][$kk]['status'] = -1;
                    }
                    if ($stock_data) {
                        if (($stock_data['status'] == 0)) {
                            $hotel_house[$k]['stock'][$kk]['status'] = 0;
                        } else {
                            if ($stock_data['type'] == 0) {
                                $hotel_house[$k]['stock'][$kk]['status'] = 2;
                                $hotel_house[$k]['stock'][$kk]['stock_num'] = '';
                            } else {
                                if ($stock_data['stock'] == 0) {
                                    $hotel_house[$k]['stock'][$kk]['status'] = 0;
                                }else{
                                    $hotel_house[$k]['stock'][$kk]['status'] = 1;
                                    $hotel_house[$k]['stock'][$kk]['stock_num'] = $stock_data['stock'];
                                }
                            }
                        }
                    }
                }
                foreach ($price_date as $kkk => $vvv) {
                    $price_data = Yii::$app->db->createCommand("select * from hotel_date_price WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vvv}'")->queryOne();
                    $stock_data = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vvv}'")->queryOne();
                    $hotel_house1[$k]['date'][$kkk]['date_time'] = $vvv;
                    if (!$price_data) {
                        $hotel_house1[$k]['date'][$kkk]['money'] = '';
                        $hotel_house1[$k]['date'][$kkk]['scale'] = '';
                    } else {
                        $hotel_house1[$k]['date'][$kkk]['money'] = $price_data['price'];
                        $hotel_house1[$k]['date'][$kkk]['scale'] = $price_data['scale'];
                    }
                    if (!$stock_data) {
                        $hotel_house1[$k]['date'][$kkk]['status'] = -1;
                    } else {
                        if ($stock_data['status'] == 0 || ($stock_data['type'] == 1 && $stock_data['stock'] == 0)) {
                            $hotel_house1[$k]['date'][$kkk]['status'] = 0; //满房
                        } else {
                            $hotel_house1[$k]['date'][$kkk]['status'] = -1;
                        }
                    }
                }
            }
            return $this->render('set-price', ['date' => $date, 'hotel_house' => $hotel_house, 'price_date' => $price_date, 'price_data' => $hotel_house1]);
        } catch (Exception $e) {
            return $this->render('error');
        }
    }

    //设置房价
    public function actionSetPrice1()
    {
        try {
            $hotel_id = Yii::$app->request->get('hotel_id');
            $session_str = 'hotel_price_' . $hotel_id;
            $start_date = $_SESSION[$session_str] ? $_SESSION[$session_str] : date('Y-m-d', time());
            $end_date = date("Y-m-d", strtotime("+1 months", strtotime($start_date)));
            $date = CommonService::getDate($start_date, $end_date);
            $price_end_date = date("Y-m-d", strtotime("+8 day", strtotime($start_date)));
            $price_date = CommonService::getDate($start_date, $price_end_date);
            $hotel_house = Yii::$app->db->createCommand("select id,name,hotel_id from hotel_house WHERE hotel_id=$hotel_id")->queryAll();
            $hotel_house1 = $hotel_house;
            foreach ($hotel_house as $k => $v) {
                foreach ($date as $kk => $vv) {
                    $stock_data = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vv}'")->queryOne();
                    if (!$stock_data) {
                        $hotel_house[$k]['stock'][$kk]['status'] = -1;
                    }
                    if ($stock_data) {
                        if (($stock_data['status'] == 0 or $stock_data['stock'] === 0)) {
                            $hotel_house[$k]['stock'][$kk]['status'] = 0;
                        } else {
                            if ($stock_data['type'] == 0) {
                                $hotel_house[$k]['stock'][$kk]['status'] = 2;
                                $hotel_house[$k]['stock'][$kk]['stock_num'] = '';
                            } else {
                                if ($stock_data['stock'] == 0) {
                                    $hotel_house[$k]['stock'][$kk]['status'] = 0;
                                }else{
                                    $hotel_house[$k]['stock'][$kk]['status'] = 1;
                                    $hotel_house[$k]['stock'][$kk]['stock_num'] = $stock_data['stock'];
                                }
                            }
                        }
                    }
                }
                foreach ($price_date as $kkk => $vvv) {
                    $price_data = Yii::$app->db->createCommand("select * from hotel_date_price WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vvv}'")->queryOne();
                    $stock_data = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vvv}'")->queryOne();
                    $hotel_house1[$k]['date'][$kkk]['date_time'] = $vvv;
                    if (!$price_data) {
                        $hotel_house1[$k]['date'][$kkk]['money'] = '';
                        $hotel_house1[$k]['date'][$kkk]['scale'] = '';
                    } else {
                        $hotel_house1[$k]['date'][$kkk]['money'] = $price_data['price'];
                        $hotel_house1[$k]['date'][$kkk]['scale'] = $price_data['scale'];
                    }
                    if (!$stock_data) {
                        $hotel_house1[$k]['date'][$kkk]['status'] = -1;
                    } else {
                        if ($stock_data['status'] == 0 || ($stock_data['type'] == 1 && $stock_data['stock'] == 0)) {
                            $hotel_house1[$k]['date'][$kkk]['status'] = 0; //满房
                        } else {
                            $hotel_house1[$k]['date'][$kkk]['status'] = -1;
                        }
                    }
                }
            }
            return $this->render('set-price1', ['date' => $date, 'hotel_house' => $hotel_house, 'price_date' => $price_date, 'price_data' => $hotel_house1]);
        } catch (Exception $e) {
            return $this->render('error');
        }
    }

    public function actionBatchStatus()
    {
        if (Yii::$app->request->isAjax) {
            if (!isset($_POST['house_status']) || !isset($_POST['house_num'])) {
                echo -1;
                die;
            }
            $hotel_id = Yii::$app->request->post('hotel_id');
            $house_status = Yii::$app->request->post('house_status');
            $stock_status = Yii::$app->request->post('house_num');
            $hotel_house_id = Yii::$app->request->post('hotel_house_str');
            $start_time = Yii::$app->request->post('start_time');
            $end_time = Yii::$app->request->post('end_time');
            $week = Yii::$app->request->post('house_week');
            $stock = Yii::$app->request->post('stock');
            if (empty($hotel_house_id) || empty($start_time) || empty($end_time) || empty($hotel_id)) {
                echo -1;
                die;
            }
            $hotel_house_id = explode(',', $hotel_house_id);
            if (empty($hotel_house_id)) {
                echo -1;
                die;
            }
            foreach ($hotel_house_id as $k => $v) {
                $old_data = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id={$v}")->queryAll();
                if ($house_status == 2 && empty($old_data)) {
                    echo -2;
                    die;
                }
            }
            if ($house_status == 2 && $stock_status == 0) {
                echo -2;
                die;
            }
            if (isset($_POST['house_week']) && !empty($week)) {
                $week = explode(',', $week);
                $date_data = CommonService::getDate($start_time, $end_time);
                if (empty($date_data) || empty($week)) {
                    echo -1;
                    die;
                }
                foreach ($date_data as $k => $v) {
                    $date_num = date('N', strtotime($v));
                    if (!in_array($date_num, $week)) {
                        unset($date_data[$k]);
                    }
                }
            } else {
                $date_data = CommonService::getDate($start_time, $end_time);
            }
            $shiwu = Yii::$app->db->beginTransaction();
            try {
                foreach ($hotel_house_id as $k => $v) {
                    foreach ($date_data as $kk => $vv) {
                        $old_date = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id={$v} AND date_time='{$vv}'")->queryOne();
                        switch ($house_status) {
                            case 2:
                                switch ($stock_status) {
                                    case 0:
                                        echo -1;
                                        die;
                                    case 1:
                                        if ($old_date) {
                                            Yii::$app->db->createCommand("update hotel_date_status set stock={$stock},type=1 WHERE id={$old_date['id']}")->execute();
                                        } else {
                                            Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,stock,type) VALUES ($hotel_id,{$v},'{$vv}',0,$stock,1)")->execute();
                                        }
                                        break;
                                }
                                break;
                            case 1:
                                switch ($stock_status) {
                                    case 0:
                                        if ($old_date) {
                                            Yii::$app->db->createCommand("update hotel_date_status set status=1,type=0 WHERE id={$old_date['id']}")->execute();
                                        } else {
                                            Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,type) VALUES ($hotel_id,{$v},'{$vv}',1,0)")->execute();
                                        }
                                        break;
                                    case 1:
                                        if ($old_date) {
                                            Yii::$app->db->createCommand("update hotel_date_status set status=1,type=1,stock={$stock} WHERE id={$old_date['id']}")->execute();
                                        } else {
                                            Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,stock,type) VALUES ($hotel_id,{$v},'{$vv}',1,{$stock},1)")->execute();
                                        }
                                        break;
                                }
                                break;
                            case 0:
                                switch ($stock_status) {
                                    case 0:
                                        if ($old_date) {
                                            Yii::$app->db->createCommand("update hotel_date_status set status=0 WHERE id={$old_date['id']}")->execute();
                                        } else {
                                            Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,type) VALUES ($hotel_id,{$v},'{$vv}',0,0)")->execute();
                                        }
                                        break;
                                    case 1:
                                        if ($old_date) {
                                            Yii::$app->db->createCommand("update hotel_date_status set status=0,type=1,stock={$stock} WHERE id={$old_date['id']}")->execute();
                                        } else {
                                            Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,type,stock) VALUES ($hotel_id,{$v},'{$vv}',0,1,{$stock})")->execute();
                                        }
                                        break;
                                }
                        }
                    }
                }
                $shiwu->commit();
                echo 1;
                die;
            } catch (Exception $e) {
                $shiwu->rollBack();
                echo -3;
                die;
            }
        }
    }

    public function actionBatchPrice()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_id = Yii::$app->request->post('hotel_id');
            $hotel_house_id = Yii::$app->request->post('hotel_house_str');
            $start_time = Yii::$app->request->post('start_time');
            $end_time = Yii::$app->request->post('end_time');
            $week = Yii::$app->request->post('house_week');
            $price_dj = Yii::$app->request->post('house_dj');
            $price_yj = Yii::$app->request->post('house_yj');
            $yj_preg = "/^(?:\d{1,3}|1000)$/";
            $dj_preg = "/^[0-9]+(.[0-9]{2})?$/";
            if (empty($hotel_house_id) || empty($start_time) || empty($end_time) || empty($hotel_id)) {
                echo -1;
                die;
            }
            $hotel_house_id = explode(',', $hotel_house_id);
            if (empty($hotel_house_id)) {
                echo -1;
                die;
            }
            $bool1 = preg_match($dj_preg, $price_dj);
            $bool2 = preg_match($yj_preg, $price_yj);
            if (!$bool1) {
                echo -2;
                die;
            }
            if (!$bool2) {
                echo -3;
                die;
            }
            if (isset($_POST['house_week']) && !empty($week)) {
                $week = explode(',', $week);
                $date_data = CommonService::getDate($start_time, $end_time);
                if (empty($date_data) || empty($week)) {
                    echo -1;
                    die;
                }
                foreach ($date_data as $k => $v) {
                    $date_num = date('N', strtotime($v));
                    if (!in_array($date_num, $week)) {
                        unset($date_data[$k]);
                    }
                }
            } else {
                $date_data = CommonService::getDate($start_time, $end_time);
            }
            $sale_price = $price_dj * (1 + $price_yj / 100);
            foreach ($hotel_house_id as $k => $v) {
                foreach ($date_data as $kk => $vv) {
                    $old_date = Yii::$app->db->createCommand("select * from hotel_date_price WHERE hotel_id=$hotel_id AND hotel_house_id={$v} AND date_time='{$vv}'")->queryOne();
                    if ($old_date) {
                        $bool = Yii::$app->db->createCommand("update hotel_date_price set price={$price_dj},`scale`={$price_yj},`sale_price`={$sale_price} WHERE id={$old_date['id']}")->execute();
                    } else {
                        $bool = Yii::$app->db->createCommand("insert into hotel_date_price(hotel_id,hotel_house_id,date_time,price,scale,sale_price) VALUES ($hotel_id,{$v},'{$vv}',$price_dj,$price_yj,$sale_price)")->execute();
                    }
                    if($bool===false){
                        echo 0;die;
                    } else {
                        $sql_status = 1;
                    }
                }
            }
            echo $sql_status;
        }
    }

    public function actionSetStatus()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_id = Yii::$app->request->post('hotel_id');
            $hotel_house_id = Yii::$app->request->post('hotel_house_id');
            $house_status = Yii::$app->request->post('house_status');
            $stock_status = Yii::$app->request->post('stock_status');
            $stock = Yii::$app->request->post('stock');
            $date = Yii::$app->request->post('date');
            if (empty($hotel_id) || empty($hotel_house_id) || empty($date)) {
                echo -1;
                die;
            }
            $old_data = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id=$hotel_house_id AND date_time='{$date}'")->queryOne();
            if (empty($old_data) && $house_status == 2) {
                echo -2;
                die;
            }
            if ($house_status == 2 && $stock_status == 0) {
                echo -2;
                die;
            }
            switch ($house_status) {
                case 2:
                    switch ($stock_status) {
                        case 0:
                            echo -2;
                            die;
                        case 1:
                            if ($old_data) {
                                $bool = Yii::$app->db->createCommand("update hotel_date_status set stock={$stock},type=1 WHERE id={$old_data['id']}")->execute();
                                break;
                            } else {
                                $bool = Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,stock,type) VALUES ($hotel_id,$hotel_house_id,'{$date}',0,$stock,1)")->execute();
                            }
                            break;
                    }
                    break;
                case 1:
                    switch ($stock_status) {
                        case 0:
                            if ($old_data) {
                                $bool = Yii::$app->db->createCommand("update hotel_date_status set status=1 WHERE id={$old_data['id']}")->execute();
                            } else {
                                $bool = Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,type) VALUES ($hotel_id,$hotel_house_id,'{$date}',1,0)")->execute();
                            }
                            break;
                        case 1:
                            if ($old_data) {
                                $bool = Yii::$app->db->createCommand("update hotel_date_status set status=1,stock=$stock,type=1 WHERE id={$old_data['id']}")->execute();
                            } else {
                                $bool = Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,stock,type) VALUES ($hotel_id,$hotel_house_id,'{$date}',1,$stock,1)")->execute();
                            }
                            break;
                    }
                    break;
                case 0:
                    switch ($stock_status) {
                        case 0:
                            if ($old_data) {
                                $bool = Yii::$app->db->createCommand("update hotel_date_status set status=0 WHERE id={$old_data['id']}")->execute();
                            } else {
                                $bool = Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,type) VALUES ($hotel_id,$hotel_house_id,'{$date}',0,0)")->execute();
                            }
                            break;
                        case 1:
                            if ($old_data) {
                                $bool = Yii::$app->db->createCommand("update hotel_date_status set status=0,type=1,stock={$stock} WHERE id={$old_data['id']}")->execute();
                            } else {
                                $bool = Yii::$app->db->createCommand("insert into hotel_date_status(hotel_id,hotel_house_id,date_time,status,type,stock) VALUES ($hotel_id,$hotel_house_id,'{$date}',0,1,{$stock})")->execute();
                            }
                            break;
                    }
                    break;
            }
            echo $bool;
            die;
        }
    }

    public function actionUpdatePrice()
    {
        if (Yii::$app->request->isAjax) {
            $preg = "/^[0-9]+(.[0-9]{2})?$/";
            $hotel_id = Yii::$app->request->post('hotel_id');
            $hotel_house_id = Yii::$app->request->post('hotel_house_id');
            $date = Yii::$app->request->post('date');
            $price = Yii::$app->request->post('price');
            if (empty($hotel_id) || empty($hotel_house_id)) {
                echo -1;
                die;
            }
            $price = explode(',', $price);
            foreach ($price as $k => $v) {
                if ($v) {
                    $bool = preg_match($preg, $v);
                    if (!$bool) {
                        echo -2;
                        die;
                    }
                }
            }
            $date = explode(',', $date);
            foreach ($date as $k => $v) {
                $data[] = [
                    'date' => $v,
                    'money' => $price[$k]
                ];
            }
            foreach ($data as $k => $v) {
                if (!$v['date'] || $v['money'] == '') {
                    unset($data[$k]);
                }
            }
            if (!empty($data)) {
                $shiwu = Yii::$app->db->beginTransaction();
                try {
                    foreach ($data as $k => $v) {
                        $old_data = Yii::$app->db->createCommand("select * from hotel_date_price WHERE hotel_id=$hotel_id AND hotel_house_id=$hotel_house_id AND date_time='{$v['date']}'")->queryOne();
                        if ($old_data) {
                            $sale_price = $v['money'] * (1 + $old_data['scale'] / 100);
                            Yii::$app->db->createCommand("update hotel_date_price set price={$v['money']},sale_price={$sale_price} WHERE id={$old_data['id']}")->execute();
                        } else {
                            $sale_price = $v['money'] * (1 + 10 / 100);
                            Yii::$app->db->createCommand("insert into hotel_date_price(hotel_id,hotel_house_id,date_time,price,scale,sale_price) VALUES ($hotel_id,$hotel_house_id,'{$v['date']}',{$v['money']},10,{$sale_price})")->execute();
                        }
                    }
                    $shiwu->commit();
                    echo 1;
                    die;
                } catch (Exception $e) {
                    $shiwu->rollBack();
                    echo 0;
                    die;
                }
            }
        }
    }

    public function actionUpdateScale()
    {
        if (Yii::$app->request->isAjax) {
            $preg = "/^(?:\d{1,3}|1000)$/";
            $hotel_id = Yii::$app->request->post('hotel_id');
            $hotel_house_id = Yii::$app->request->post('hotel_house_id');
            $date = Yii::$app->request->post('date');
            $price = Yii::$app->request->post('price');
            if (empty($hotel_id) || empty($hotel_house_id)) {
                echo -1;
                die;
            }
            $price = explode(',', $price);
            foreach ($price as $k => $v) {
                if ($v) {
                    $bool = preg_match($preg, $v);
                    if (!$bool) {
                        echo -2;
                        die;
                    }
                }
            }
            $date = explode(',', $date);
            foreach ($date as $k => $v) {
                $data[] = [
                    'date' => $v,
                    'money' => $price[$k]
                ];
            }
            foreach ($data as $k => $v) {
                if (!$v['date'] || $v['money'] == '') {
                    unset($data[$k]);
                }
            }
            if (!empty($data)) {
                $shiwu = Yii::$app->db->beginTransaction();
                try {
                    foreach ($data as $k => $v) {
                        $old_data = Yii::$app->db->createCommand("select * from hotel_date_price WHERE hotel_id=$hotel_id AND hotel_house_id=$hotel_house_id AND date_time='{$v['date']}'")->queryOne();
                        if ($old_data) {
                            $sale_price = $old_data['price'] * (1+ $v['money'] / 100);
                            Yii::$app->db->createCommand("update hotel_date_price set scale={$v['money']},sale_price=$sale_price WHERE id={$old_data['id']}")->execute();
                        } else {
                            Yii::$app->db->createCommand("insert into hotel_date_price(hotel_id,hotel_house_id,date_time,scale,sale_price) VALUES ($hotel_id,$hotel_house_id,'{$v['date']}',{$v['money']},0)")->execute();
                        }
                    }
                    $shiwu->commit();
                    echo 1;
                    die;
                } catch (Exception $e) {
                    $shiwu->rollBack();
                    echo 0;
                    die;
                }
            }
        }
    }

    public function actionUpdateSession()
    {
        if (Yii::$app->request->isAjax) {
            $date = Yii::$app->request->post('date');
            $hotel_id = Yii::$app->request->post('hotel_id');
            $_SESSION['hotel_' . $hotel_id] = $date;
        }
    }

    public function actionUpdateSession1()
    {
        if (Yii::$app->request->isAjax) {
            $date = Yii::$app->request->post('date');
            $hotel_id = Yii::$app->request->post('hotel_id');
            $_SESSION['hotel_price_' . $hotel_id] = $date;
        }
    }

    public function actionUpdateNext()
    {
        if (Yii::$app->request->isAjax) {
            $date = Yii::$app->request->post('date');
            $date = date("Y-m-d", strtotime("+1 months", strtotime($date)));
            $hotel_id = Yii::$app->request->post('hotel_id');
            $_SESSION['hotel_' . $hotel_id] = $date;
        }
    }

    public function actionUpdatePrev()
    {
        if (Yii::$app->request->isAjax) {
            $date = Yii::$app->request->post('date');
            $date = date("Y-m-d", strtotime("-1 months", strtotime($date)));
            $hotel_id = Yii::$app->request->post('hotel_id');
            $_SESSION['hotel_' . $hotel_id] = $date;
        }
    }

    public function actionUpdatePrev2()
    {
        if (Yii::$app->request->isAjax) {
            $date = Yii::$app->request->post('date');
            $date = date("Y-m-d", strtotime("-9 day", strtotime($date)));
            $hotel_id = Yii::$app->request->post('hotel_id');
            $_SESSION['hotel_price_' . $hotel_id] = $date;
        }
    }

    public function actionUpdateNext2()
    {
        if (Yii::$app->request->isAjax) {
            $date = Yii::$app->request->post('date');
            $date = date("Y-m-d", strtotime("+9 day", strtotime($date)));
            $hotel_id = Yii::$app->request->post('hotel_id');
            $_SESSION['hotel_price_' . $hotel_id] = $date;
        }
    }

    /**
     * 添加联系人信息
     * @return string
     */
    public function actionContact()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }
        //查询现有的联系人
        $contact = Yii::$app->db->createCommand("select * from hotel_contact where theme = 2 and theme_id = :theme_id")
            ->bindValue(":theme_id", $id)
            ->queryAll();
        return $this->render('add-contact', [
            'id' => $id,
            'contact' => $contact,
        ]);
    }

    /**
     * 保存联系人信息
     * @throws \yii\db\Exception
     */
    public function actionSaveContact()
    {
        if (Yii::$app->request->isAjax) {
            $type = Yii::$app->request->post('type');
            $name = Yii::$app->request->post('name');
            $job = Yii::$app->request->post('job');
            $mobile = Yii::$app->request->post('mobile');
            $email = Yii::$app->request->post('email');
            $landline = Yii::$app->request->post('landline');
            $theme_id = Yii::$app->request->post('theme_id');
            $theme = 2;
            $sms_status = Yii::$app->request->post('sms_status');//酒店2.1 admin:ys time:2017/11/2
            Yii::$app->db->createCommand("INSERT INTO hotel_contact(theme,theme_id,type,name,job,mobile,email,landline,sms_status,admin_id) VALUES(:theme,:theme_id,:type,:name,:job,:mobile,:email,:landline,:sms_status,:admin_id)")
                ->bindValue(":theme", $theme)
                ->bindValue(":theme_id", $theme_id)
                ->bindValue(":type", $type)
                ->bindValue(":name", $name)
                ->bindValue(":job", $job)
                ->bindValue(":mobile", $mobile)
                ->bindValue(":email", $email)
                ->bindValue(":landline", $landline)
                //酒店2.1 ↓ admin:ys time:2017/11/2
                ->bindValue(":sms_status", $sms_status)
                ->bindValue(":admin_id", Yii::$app->user->getId())
                //酒店2.1 结束 ↑
                ->execute();
            echo Yii::$app->db->getLastInsertID();
        }
    }

    /**
     * 保存联系人信息
     * @throws \yii\db\Exception
     */
    public function actionUpdateContact()
    {
        if (Yii::$app->request->isAjax) {
//            dd(Yii::$app->request->post());
            $type = Yii::$app->request->post('type');
            $name = Yii::$app->request->post('name');
            $job = Yii::$app->request->post('job');
            $mobile = Yii::$app->request->post('mobile');
            $email = Yii::$app->request->post('email');
            $landline = Yii::$app->request->post('landline');
            $id = Yii::$app->request->post('id');
            $sms_status = Yii::$app->request->post('sms_status');//酒店2.1 admin:ys time:2017/11/2
            echo Yii::$app->db->createCommand("UPDATE hotel_contact SET type = :type,name=:name,job=:job,mobile=:mobile,email=:email,landline=:landline,sms_status=:sms_status,update_date=:update_date,admin_id=:admin_id WHERE id = :id")
                ->bindValue(":type", $type)
                ->bindValue(":name", $name)
                ->bindValue(":job", $job)
                ->bindValue(":mobile", $mobile)
                ->bindValue(":email", $email)
                ->bindValue(":landline", $landline)
                //酒店2.1 ↓ admin:ys time:2017/11/2
                ->bindValue(":sms_status", $sms_status)
                ->bindValue(":update_date", date('Y-m-d H:i:s'))
                ->bindValue(":admin_id", Yii::$app->user->getId())
                //酒店2.1 结束 ↑
                ->bindValue(":id", $id)
                ->execute();
        }
    }

    /**
     * 删除联系人信息
     * @throws \yii\db\Exception
     */
    public function actionDelContact()
    {
        if (Yii::$app->request->isAjax) {
            $contactId = Yii::$app->request->post('contactId');
            echo Yii::$app->db->createCommand("DELETE FROM hotel_contact WHERE id = :id")
                ->bindValue(":id", $contactId)
                ->execute();
        }
    }

    /**
     * 酒店图片管理
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionHotelPic()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }
        $model = new HotelImg();
        //if ($model->load(Yii::$app->request->post())) {
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $pic = [];
            $trans = Yii::$app->db->beginTransaction();
            try {
                if (!empty(Yii::$app->request->post()['pic'])) {
                    //首先--查询当前类型的图片有没有设置首图
                    $hotel_cover_img = Yii::$app->db->createCommand("SELECT count(*) as num FROM hotel_img WHERE  hotel_id = :hotel_id AND type = :type AND is_cover_img = 1")
                        ->bindValue(":hotel_id", $id)
                        ->bindValue(":type", Yii::$app->request->post()['type'])
                        ->queryOne();

                    //其次--删除原先的图片
                    $sql = "delete from hotel_img WHERE hotel_id = :hotel_id AND type = :type";
                    Yii::$app->db->createCommand($sql)
                        ->bindValue(":hotel_id", $id)
                        ->bindValue(":type", Yii::$app->request->post()['type'])
                        ->execute();
                    //批量添加图片、
                    foreach (Yii::$app->request->post()['pic'] as $key => $val) {
                        $pic[$key]['hotel_id'] = $id;
                        $pic[$key]['pic'] = $val;
                        $pic[$key]['type'] = Yii::$app->request->post()['type'];
                        $pic[$key]['des'] = Yii::$app->request->post()['pic_desc'][$key] . "";
                        $is_cover_img = 0;
                        //判断如果页面传递过来的首图图片和当前循环到的图片一致，则将is_cover_img 设置为1
                        if (Yii::$app->request->post()['cover_img'] != "") {
                            if ($val == Yii::$app->request->post()['cover_img'])
                                $is_cover_img = 1;
                            else
                                $is_cover_img = 0;
                        } //如果用户并未主动设置首图，并且原先数据库中并没有给此类型的图片设置首图，则设置上传的图片中第一张为首图
                        else {
                            if ($hotel_cover_img['num'] == 0 && $key == 0) {
                                $is_cover_img = 1;
                            }
                        }

                        $pic[$key]['is_cover_img'] = $is_cover_img;
                    }
                    //添加图片
                    $resule = Yii::$app->db->createCommand()->batchInsert('hotel_img', ['hotel_id', 'pic', 'type', 'des', 'is_cover_img'], $pic)->execute();

                    /*//查询酒店信息--获取当前的审核状态
                    $hotel = Yii::$app->db->createCommand("select check_status from hotel where id = :id")
                        ->bindValue(":id", $id)
                        ->queryOne();
                    //修改酒店状态为待审核
                    Yii::$app->db->createCommand("UPDATE hotel SET check_status = 0 WHERE id = :id")
                        ->bindValue(":id", $id)
                        ->execute();
                    //添加审核信息
                    Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                        ->bindValue(":hotel_id", $id)
                        ->bindValue(":before_status", $hotel['check_status'])
                        ->bindValue(":after_status", 0)
                        ->bindValue(":remarks", "添加酒店" . Yii::$app->params['hotel_img_type'][Yii::$app->request->post()['type']] . "图片，提交审核")
                        ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                        ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                        ->execute();*/
                }
                $trans->commit();
                //return $this->redirectAndMsg(['hotel-pic', 'id' => $id],'操作成功','success');
            } catch (Exception $e) {
                Yii::$app->session->setFlash('errors', '添加失败');
                $trans->rollBack();
            }
        }
        //查询酒店所有的图片
        $hotelImg = Yii::$app->db->createCommand("SELECT * FROM hotel_img WHERE hotel_id = :hotel_id")
            ->bindValue(":hotel_id", $id)
            ->queryAll();

        return $this->render('hotel-pic', [
            'id' => $id,
            'hotelImg' => $hotelImg,
        ]);
    }

    /**
     * 设置酒店图片为头图
     * @throws \yii\db\Exception
     */
    public function actionSetCoverImg()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_id = Yii::$app->request->post('hotel_id');
            $title_pic = Yii::$app->request->post('title_pic');
            $type = Yii::$app->request->post('type');

            if (empty($hotel_id) || empty($title_pic) || empty($type)) {
                echo -1;
                die;
            }
            $trans = Yii::$app->db->beginTransaction();
            try {
                //将当前酒店下，当前类型下之前的首图设置为0，
                Yii::$app->db->createCommand("update hotel_img set is_cover_img= 0 WHERE hotel_id = :hotel_id and type = :type and is_cover_img = 1")
                    ->bindValue(":hotel_id", $hotel_id)
                    ->bindValue(":type", $type)
                    ->execute();
                //重新设置首图
                Yii::$app->db->createCommand("update hotel_img set is_cover_img= 1 WHERE hotel_id = :hotel_id and type = :type and pic = :pic")
                    ->bindValue(":hotel_id", $hotel_id)
                    ->bindValue(":type", $type)
                    ->bindValue(":pic", $title_pic)
                    ->execute();
                /*//查询酒店信息--获取当前的审核状态
                $hotel = Yii::$app->db->createCommand("select check_status from hotel where id = :id")
                    ->bindValue(":id", $hotel_id)
                    ->queryOne();
                //修改酒店状态为待审核
                Yii::$app->db->createCommand("UPDATE hotel SET check_status = 0 WHERE id = :id")
                    ->bindValue(":id", $hotel_id)
                    ->execute();
                //添加审核信息
                Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                    ->bindValue(":hotel_id", $hotel_id)
                    ->bindValue(":before_status", $hotel['check_status'])
                    ->bindValue(":after_status", 0)
                    ->bindValue(":remarks", "重新设置酒店" . Yii::$app->params['hotel_img_type'][$type] . "图片首图，重新提交审核")
                    ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                    ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                    ->execute();*/
                $trans->commit();
                echo 1;
            } catch (Exception $e) {
                $trans->rollBack();
                echo -2;
            }
            die;
        }
    }

    /**
     * 设置酒店首图为空
     * @throws \yii\db\Exception
     */
    public function actionDelHotelCover()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_id = Yii::$app->request->post('hotel_id');
            $type = Yii::$app->request->post('type');
            $del_img = Yii::$app->request->post('del_img');
            echo Yii::$app->db->createCommand("update hotel_img set is_cover_img = 1 WHERE hotel_id=:hotel_id and type=:type and pic=:pic")
                ->bindValue(":hotel_id", $hotel_id)
                ->bindValue(":type", $type)
                ->bindValue(":pic", $del_img)
                ->execute();
        }
    }

    /**
     * 删除酒店图片
     * @throws \yii\db\Exception
     */
    public function actionDelHotelPic()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_id = Yii::$app->request->post('hotel_id');
            $type = Yii::$app->request->post('type');
            $del_img = Yii::$app->request->post('del_img');
            $cover = Yii::$app->request->post('cover');
            $trans = Yii::$app->db->beginTransaction();
            try {
                //如果当前删除的图片为首图的话，需要设置该类型的第一张图片为首图
                if ($cover == 1) {
                    //查询第一张图片的id
                    $hotel_img = Yii::$app->db->createCommand("SELECT id FROM hotel_img WHERE type = :type and hotel_id = :hotel_id and is_cover_img = 0 limit 1 ")
                        ->bindValue(":type", $type)
                        ->bindValue(":hotel_id", $hotel_id)
                        ->queryOne();
                    //将第一张图片设置为首图
                    $sql = "UPDATE hotel_img SET is_cover_img = 1 WHERE id = " . $hotel_img['id'];
                    Yii::$app->db->createCommand("UPDATE hotel_img SET is_cover_img = 1 WHERE id = :id")
                        ->bindValue(":id", $hotel_img['id'])
                        ->execute();
                }
                //删除图片
                $res = Yii::$app->db->createCommand("DELETE FROM hotel_img WHERE  hotel_id=:hotel_id and type=:type and pic=:pic")
                    ->bindValue(":hotel_id", $hotel_id)
                    ->bindValue(":type", $type)
                    ->bindValue(":pic", "$del_img")
                    ->execute();
                //查询酒店信息--获取当前的审核状态
                /*$hotel = Yii::$app->db->createCommand("select check_status from hotel where id = :id")
                    ->bindValue(":id", $hotel_id)
                    ->queryOne();
                //修改酒店状态为待审核
                Yii::$app->db->createCommand("UPDATE hotel SET check_status = 0 WHERE id = :id")
                    ->bindValue(":id", $hotel_id)
                    ->execute();
                //添加审核信息
                Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                    ->bindValue(":hotel_id", $hotel_id)
                    ->bindValue(":before_status", $hotel['check_status'])
                    ->bindValue(":after_status", 0)
                    ->bindValue(":remarks", "删除酒店" . Yii::$app->params['hotel_img_type'][$type] . "图片信息，重新提交审核")
                    ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                    ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                    ->execute();*/
                $trans->commit();
                echo 1;

            } catch (Exception $e) {
                $trans->rollBack();
                echo -2;
            }
        }
    }

    /**
     * 修改审核状态
     */
    public function actionCheckStatus()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_id = Yii::$app->request->post('hotel_id');
            $remarks = Yii::$app->request->post('remarks');
            $check_status = Yii::$app->request->post('check_status');
            $before_check_status = Yii::$app->request->post('before_check_status');
            if (empty($hotel_id) || intval($check_status) < 0) {
                echo -1;
                die;
            }
            $trans = Yii::$app->db->beginTransaction();
            try {
                //修改酒店审核状态
                $upRes = Yii::$app->db->createCommand("UPDATE hotel SET check_status = :check_status WHERE id = :id")
                    ->bindValue(":check_status", $check_status)
                    ->bindValue(":id", $hotel_id)
                    ->execute();
                //添加审核日志信息
                $inRes = Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (hotel_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:hotel_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
                    ->bindValue(":hotel_id", $hotel_id)
                    ->bindValue(":before_status", $before_check_status)
                    ->bindValue(":after_status", $check_status)
                    ->bindValue(":remarks", $remarks)
                    ->bindValue(":check_adminname", Yii::$app->user->identity['username'])
                    ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
                    ->execute();
                $trans->commit();
                echo 1;
            } catch (Exception $e) {
                $trans->rollBack();
                echo -2;
            }
            die;
        }
    }

    /**
     * 修改酒店状态
     */
    public function actionUpdateHotelStatus()
    {
        if (Yii::$app->request->isAjax) {
            $hotel_id = Yii::$app->request->post('hotel_id');
            $status = Yii::$app->request->post('status');
            $before_status = Yii::$app->request->post('before_status');
            if (empty($hotel_id)) {
                echo -1;
                die;
            }
            $trans = Yii::$app->db->beginTransaction();
            try {
                if ($status == 0) {
                    $update_time = null;
                    //如果将酒店改为停用状态，那酒店的审核状态改为已关闭
                    $sql = "UPDATE hotel SET status = :status,update_time=:update_time,check_status=3 WHERE id = :id";
                }
                if ($status == 1) {
                    $update_time = date("Y-m-d H:i:s", time());
                    $sql = "UPDATE hotel SET status = :status,update_time=:update_time WHERE id = :id";
                }
                //修改酒店审核状态
                $res = Yii::$app->db->createCommand($sql)
                    ->bindValue(":status", $status)
                    ->bindValue(":update_time", $update_time)
                    ->bindValue(":id", $hotel_id)
                    ->execute();
                $trans->commit();
                $url1 = JavaUrl . "/api/synSorl/synSorlByHotelId";
                $data1 = array(
                    'hotelId' => $hotel_id
                );
                $obj = new Submit();
                $obj->sub_post($url1, json_encode($data1));
                echo 1;
            } catch (Exception $e) {
                $trans->rollBack();
                echo -2;
            }
            die;
        }
    }

    /**
     * 查询所有的供应商信息
     * @return string
     */
    public function actionSupplier()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }

        $HotelModel = Hotel::findOne($id);
        //查询供应商
        $searchModel = new HotelSupplierQuery();
        $searchModel->optype = 1;
        $searchModel->id = $HotelModel->supplier_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('supplier', [
            'id' => $id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'HotelModel' => $HotelModel,
        ]);
    }


    /**
     * 关联供应商
     */
    public function actionRelationSupplier()
    {
        if (Yii::$app->request->isAjax) {
            $supplier_relation = Yii::$app->request->post('supplier_relation');
            $hotel_id = Yii::$app->request->post('hotel_id');
            $supplier_id = Yii::$app->request->post('supplier_id');
            if (empty($hotel_id) || empty($supplier_id)) {
                echo -1;
                die;
            }
            $trans = Yii::$app->db->beginTransaction();
            try {
                if ($supplier_relation == 2) {
                    $supplier_id = 0;
                }

                //修改酒店关联供应商的信息
                /* $sql = "UPDATE hotel SET supplier_id = $supplier_id,supplier_relation=$supplier_relation WHERE id = $hotel_id";
                echo $sql;
                exit;*/
                $res = Yii::$app->db->createCommand("UPDATE hotel SET supplier_id = :supplier_id,supplier_relation=:supplier_relation WHERE id = :id")
                    ->bindValue(":supplier_id", $supplier_id)
                    ->bindValue(":supplier_relation", $supplier_relation)
                    ->bindValue(":id", $hotel_id)
                    ->execute();
                // = Yii::$app->db->createCommand($sql)->execute();

                $trans->commit();
                echo 1;

            } catch (Exception $e) {
                $trans->rollBack();
                echo -2;
            }
            die;
        }
    }

    /**
     * 查看酒店信息
     */
    public function actionView()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->render(['index']);
        }
        //查询当前的酒店基本信息
        $model = Hotel::find()->where(['id' => $id])->one();
        /*if ($model->load(Yii::$app->request->post())) {

        }*/

        $provice = RegionService::getRegion(1, 10001);
        $city = RegionService::getRegion(2, $model->province);
        $area = RegionService::getRegion(3, $model->city);
        $model->introduction = str_replace("<br>", "\n", $model->introduction);
        //酒店特色文本域换行问题
        $model->feature = str_replace("<br>", "\n", $model->feature);
        //发票提示文本域换行问题
        $model->prompt = str_replace("<br>", "\n", $model->prompt);

        //查询酒店已有的设施
        $ser_fac = Yii::$app->db->createCommand("SELECT * FROM hotel_service_facilities WHERE hotel_id = " . $id)->queryAll();
        $res = [];
        if (!empty($ser_fac)) {
            foreach ($ser_fac as $key => $val) {
                $res[] = $val['facilities_id'];
            }
        }
        //获取所有的设施服务
        $facilities = HotelService::getAllFacilities();

        //获取房型
        $sql = "SELECT id,name,breakfast,room_size,type,refund_type,cover_img FROM hotel_house WHERE hotel_id = :hotel_id and status != 3";
        $house = Yii::$app->db->createCommand($sql)->bindValue(":hotel_id", $id)->queryAll();

        //查询酒店所有的图片
        $hotelImg = Yii::$app->db->createCommand("SELECT * FROM hotel_img WHERE hotel_id = :hotel_id")
            ->bindValue(":hotel_id", $id)
            ->queryAll();

        //查询现有的联系人
        $contact = Yii::$app->db->createCommand("select * from hotel_contact where theme = 2 and theme_id = :theme_id")
            ->bindValue(":theme_id", $id)
            ->queryAll();

        //查询供应商
        $searchModel = new HotelSupplierQuery();
        $searchModel->id = $model->supplier_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $HotelModel = Hotel::findOne($id);

        //查询酒店的审核记录
        $hotelCheckLog = Yii::$app->db->createCommand("SELECT * FROM hotel_check_logs WHERE hotel_id = :hotel_id")
            ->bindValue(":hotel_id", $model->id)
            ->queryAll();

        $hotel_id = Yii::$app->request->get('id');
        $session_str = 'hotel_' . $hotel_id;
        $start_date = $_SESSION[$session_str] ? $_SESSION[$session_str] : date('Y-m-d', time());
        $end_date = date("Y-m-d", strtotime("+1 months", strtotime($start_date)));
        $date = CommonService::getDate($start_date, $end_date);
        $price_end_date = date("Y-m-d", strtotime("+8 day", strtotime($start_date)));
        $price_date = CommonService::getDate($start_date, $price_end_date);
        $hotel_house = Yii::$app->db->createCommand("select id,name,hotel_id from hotel_house WHERE hotel_id=$hotel_id")->queryAll();
        $hotel_house1 = $hotel_house;
        foreach ($hotel_house as $k => $v) {
            foreach ($date as $kk => $vv) {
                $stock_data = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vv}'")->queryOne();
                if (!$stock_data) {
                    $hotel_house[$k]['stock'][$kk]['status'] = -1;
                }
                if ($stock_data) {
                    if (($stock_data['status'] == 0 or $stock_data['stock'] === 0)) {
                        $hotel_house[$k]['stock'][$kk]['status'] = 0;
                    } else {
                        if ($stock_data['type'] == 0) {
                            $hotel_house[$k]['stock'][$kk]['status'] = 2;
                            $hotel_house[$k]['stock'][$kk]['stock_num'] = '';
                        } else {
                            $hotel_house[$k]['stock'][$kk]['status'] = 1;
                            $hotel_house[$k]['stock'][$kk]['stock_num'] = $stock_data['stock'];
                        }
                    }
                }
            }
            foreach ($price_date as $kkk => $vvv) {
                $price_data = Yii::$app->db->createCommand("select * from hotel_date_price WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vvv}'")->queryOne();
                $stock_data = Yii::$app->db->createCommand("select * from hotel_date_status WHERE hotel_id=$hotel_id AND hotel_house_id={$v['id']} AND date_time='{$vvv}'")->queryOne();
                $hotel_house1[$k]['date'][$kkk]['date_time'] = $vvv;
                if (!$price_data) {
                    $hotel_house1[$k]['date'][$kkk]['money'] = '';
                    $hotel_house1[$k]['date'][$kkk]['scale'] = '';
                } else {
                    $hotel_house1[$k]['date'][$kkk]['money'] = $price_data['price'];
                    $hotel_house1[$k]['date'][$kkk]['scale'] = $price_data['scale'];
                }
                if (!$stock_data) {
                    $hotel_house1[$k]['date'][$kkk]['status'] = -1;
                } else {
                    if ($stock_data['status'] == 0 || ($stock_data['type'] == 1 && $stock_data['stock'] == 0)) {
                        $hotel_house1[$k]['date'][$kkk]['status'] = 0; //满房
                    } else {
                        $hotel_house1[$k]['date'][$kkk]['status'] = -1;
                    }
                }
            }
        }
        return $this->render('view', [
            'model' => $model,
            'provice' => $provice,
            'city' => $city,
            'area' => $area,
            'facilities' => $facilities,
            'ser_fac' => $res,
            'house' => $house,
            'hotelImg' => $hotelImg,
            'contact' => $contact,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'HotelModel' => $HotelModel,
            'hotelCheckLog' => $hotelCheckLog,
            'date' => $date,
            'hotel_house' => $hotel_house,
            'price_date' => $price_date,
            'price_data' => $hotel_house1
        ]);
    }

    /**
     * 查看酒店房型信息
     */
    public function actionViewHouse()
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['house_id'])) {
            $house_id = Yii::$app->request->get()['house_id'];
        } else {
            return $this->redirect(['error']);
        }
        //实例化model
        $model = HotelHouse::find()->where(['id' => $house_id])->one();
        $picArr = [];
        if ($model->pic != "") {
            $picArr = explode(",", $model->pic);
        }
        return $this->render('view-house', [
            'model' => $model,
            'picArr' => $picArr,
            'cover_img' => $model->cover_img,
        ]);
    }

    /**
     * 404页面
     * @return string
     */
    public function actionError()
    {
        return $this->render('error');
    }

    //重定向并弹出信息
    public function redirectAndMsg($route, $error = null, $type = 'error')
    {
        if ($error !== null) {
//            Yii::$app->session->setFlash($type,$error);
            Yii::$app->session->setFlash('c_message', ['type' => $type, 'message' => $error, 'method' => 'alert']);
        }
        return $this->redirect($route);
    }

    //直接弹出信息
    public function alertMsg($type = "error", $message, $method = 'alert')
    {
        Yii::$app->session->setFlash('c_message', ['type' => $type, 'message' => $message, 'method' => $method]);
    }


}


