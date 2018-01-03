<?php

namespace backend\controllers;

use backend\models\HouseBatchUpdateStatus;
use backend\models\Submit;
use backend\service\AsyncRequestService;
use backend\service\CommonService;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use backend\models\HouseDetails;
use backend\models\HouseDetailsQuery;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\HouseSearch;


/**
 * HouseDetailsController implements the CRUD actions for HouseDetails model.
 */
class HouseDetailsController extends Controller
{
    /**
     * @inheritdoc
     */
    /**
     * Lists all HouseDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HouseDetailsQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = HouseSearch::findOne(['house_id' => $id]);
            $model->scenario = 'sort';
            $output = '';
            $posted = current($_POST['HouseDetails']);
            $post = ['HouseSearch' => $posted];
            if ($model->load($post)) {
                $model->save();

                $url1 = JavaUrl . "/api/solr/updatesolrbyhouseidnew/" . $id;

                $obj = new Submit();
                $obj->sub_get($url1);
                $output = $model->tango_weight;
            }
            $out = Json::encode(['output' => $output, 'message' => '']);
            return $out;
        }
        //房源类型map格式
        //$houseType = ArrayHelper::map(HouseDetails::getType(), 'id', 'type_name');
        $houseType = ArrayHelper::map(HouseDetails::getHousetype(),'id','code_name');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'houseType' => $houseType,
        ]);
    }

//    根据uid找房源

    public function actionUserview($id)
    {

        $searchModel = new HouseDetailsQuery();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('userview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all HouseDetails models.
     * @return mixed
     */
    public function actionCheck()
    {
        $searchModel = new HouseDetailsQuery();
        $searchModel->s_status = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HouseDetails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'view';
        //房屋信息
        $data = Yii::$app->db->createCommand("SELECT * FROM `house_details` as detail JOIN `house_search` as search ON search.house_id = detail.id WHERE  detail.id = {$id}")->queryOne();
        //@2017-11-7 15:46:08 fuyanfei to add minsu320[房源查看页面显示图片标签----首图的图片标签]
        $coverImg = Yii::$app->db->createCommand("SELECT img_label FROM house_img_attr WHERE img_url = :img_url AND house_id = :house_id")
            ->bindValue(":img_url",$data['cover_img'])
            ->bindValue(":house_id",$id)
            ->queryOne();
        //用户电话
        $num = Yii::$app->db->createCommand("SELECT mobile FROM `user` WHERE id = {$data['uid']}")->queryScalar();
        $house_id = $data['house_id'];
        //房源图片
        $img = Yii::$app->db->createCommand("SELECT img_url,img_label FROM `house_img_attr` WHERE house_id  = {$house_id}")->queryAll();
        //床型信息
        $bed_data = Yii::$app->db->createCommand("SELECT * FROM `house_beds` WHERE `house_id`={$house_id}")->queryAll();
        if (!$reson = Yii::$app->db->createCommand("SELECT *  FROM `house_audit_log` WHERE `house_id`={$house_id}")->queryOne()) {
            $reson = [];
        }
//        房源类型
        $typeid = $data['roomtype'];
        $roomtype = Yii::$app->db->createCommand("SELECT dt_house_type_code.code_name FROM `dt_house_type` LEFT JOIN dt_house_type_code on dt_house_type.code = dt_house_type_code.id WHERE dt_house_type.id={$typeid}")->queryScalar();

        //室内设施
        $house_facilities = Yii::$app->db->createCommand("SELECT dt_house_inside.facilities_in_name FROM `house_facilities_inside` JOIN `dt_house_inside` on house_facilities_inside.inside_id = dt_house_inside.id WHERE house_facilities_inside.house_id = {$house_id}")->queryAll();
        $house_fac = '';
        if ($house_facilities) {
            foreach ($house_facilities as $k => $v) {
                $house_fac .= $v['facilities_in_name'] . ',';
            }
        }
        $house_fac = rtrim($house_fac, ',');

        //室外设施
        $out_facilities = Yii::$app->db->createCommand("SELECT dt_house_outside.facilities_name FROM `house_facilities_outside` JOIN `dt_house_outside` on house_facilities_outside.outsid_id = dt_house_outside.id WHERE house_facilities_outside.house_id = {$house_id}")->queryAll();

        $out_fac = '';
        $out_facilities = array_unique($out_facilities);
        if ($out_facilities) {
            foreach ($out_facilities as $k => $v) {
                $out_fac .= $v['facilities_name'] . ',';
            }
        }
        $out_fac = rtrim($out_fac, ',');
        //屋内限制
        $limit_info = Yii::$app->db->createCommand("SELECT `limit_id` FROM `house_limit` WHERE `house_id`={$house_id}")->queryAll();
        $limit = '';
        if ($limit_info) {
            foreach ($limit_info as $K => $v) {
                $limit_sql = "SELECT `limit_name` FROM `dt_house_limit` WHERE id = {$v['limit_id']}";
                if ($rule = Yii::$app->db->createCommand($limit_sql)->queryScalar()) ;
                {
                    $limit .= $rule . ',';
                }
            }
        }
        $limit = rtrim($limit, ',');
        $data1 = Yii::$app->db->createCommand("select old_hid ,address,biotope,doornum from `house_details` WHERE  id = {$id}")->queryOne();
        if (!$data1['biotope'] && !$data1['doornum']) {
            $address = $data1['address'];
        } else {
            $code = Yii::$app->db->createCommand("select province,city,area from `house_search` WHERE  house_id = {$id}")->queryOne();
            $address = CommonService::get_city_name($code['province']) . CommonService::get_city_name($code['city']) . CommonService::get_city_name($code['area']) . $data1['biotope'] . $data1['doornum'];
        }
        $city_code = Yii::$app->db->createCommand("select province,city,area from `house_search` WHERE  house_id = {$id}")->queryOne();
        $province = CommonService::get_city_name($city_code['province']);
        $city = CommonService::get_city_name($city_code['city']);
        $area = CommonService::get_city_name($city_code['area']);
        $date_stock_data = $this->getData($id);
        $date_price = $date_stock_data['price'];
        $date_stock = $date_stock_data['stock'];
//        dd($date_price);
        return $this->render('view', [
            'data' => $data,
            'num' => $num,
            'img' => $img,
            'bed_data' => $bed_data,
            'limit_info' => $limit,
            'house_fac' => $house_fac,
            'out_fac' => $out_fac,
            'address' => $address,
            'province' => $province,
            'city' => $city,
            'area' => $area,
            'reson' => $reson,
            'date_price' => $date_price,
            'date_stock' => $date_stock,
            'roomtype' => $roomtype,
            'coverImg' => $coverImg,

        ]);
    }

    /**
     * Creates a new HouseDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HouseDetails();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HouseDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing HouseDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the HouseDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HouseDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HouseDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//    修改房源状态
    public function actionStatus()
    {
        $uid = Yii::$app->user->identity->getId();
        $uname = Yii::$app->user->identity['username'];
        $time = date("Y-m-d H:i:s");
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $house_id = $post['house_id'];
            $house_details = Yii::$app->db->createCommand("select * from `house_details` WHERE  id = {$house_id}")->queryOne();
            $house_search = Yii::$app->db->createCommand("select * from `house_search` WHERE  house_id = {$house_id}")->queryOne();
            $house_status = $post['house_status'];
            $reason = $post['reason'];
            $type = $post['errors'];
            $detail_reson = $post['detail_reson'];

            /**
             * @ 4.下线
             *   1.通过审核 / 上线
             *   3.不通过
             *
             */
            if ($house_status == 1) {
                Yii::$app->db->createCommand("UPDATE `house_details` set check_time ='{$time}' WHERE id = {$house_id}")->execute();
                $bool = Yii::$app->db->createCommand("UPDATE `house_search` set status = {$house_status} , online = 1 WHERE  house_id = {$house_id}")->execute();
                $data = Yii::$app->db->createCommand("select * from `house_audit_log` WHERE house_id = {$house_id}")->queryOne();
                if ($data) {
                    Yii::$app->db->createCommand("UPDATE `house_audit_log` set  name='{$uname}',result = 1,reson ='',create_time ='{$time}',admin_id={$uid} WHERE house_id = {$house_id}")->execute();
                } else {
                    Yii::$app->db->createCommand("insert into  `house_audit_log` set  name='{$uname}',result = 1,reson ='',create_time ='{$time}',house_id = {$house_id},admin_id={$uid} ")->execute();

                }
                $url = JavaUrl . "/api/solr/updatesolrbyhouseidnew/$house_id";
                $url1 = JavaUrl . "/api/gd/addlbs";
                $data = array(
                    'houseId' => $house_id
                );

                $data1 = array(
                    'houseid' => $house_id,
                    'title' => $house_details['title'],
                    'roommode' => $house_search['roommode'],
                    'price' => $house_search['price'],
                    'longitude' => $house_details['longitude'],
                    'latitude' => $house_details['latitude'],
                    'lbsid' => $house_details['lbs_id'],
                );
                $obj = new Submit();
                AsyncRequestService::send_request($url, '');
                $data = $obj->sub_post($url1, json_encode($data1));

                echo 1;
                die;
            }

            if ($house_status == 3) {

                $bool = Yii::$app->db->createCommand("UPDATE `house_search` set status = 3 , online = 0  WHERE  house_id = {$house_id}")->execute();
                Yii::$app->db->createCommand("UPDATE `house_details` set check_time ='{$time}' WHERE id = {$house_id}")->execute();
                $data = Yii::$app->db->createCommand("select * from `house_audit_log` WHERE house_id = {$house_id}")->queryOne();
                if ($data) {
                    Yii::$app->db->createCommand("UPDATE `house_audit_log` set  name='{$uname}',result = 0,reson ='{$reason}',type = '{$type}',detail_reson = '{$detail_reson}',create_time ='{$time}',admin_id={$uid} WHERE house_id = {$house_id}")->execute();
                } else {
                    Yii::$app->db->createCommand("insert into  `house_audit_log` set  name='{$uname}',result = 0,reson ='{$reason}',type = '{$type}',detail_reson = '{$detail_reson}',create_time ='{$time}',house_id = {$house_id},admin_id={$uid} ")->execute();

                }

                if ($bool == 1 || $bool == 0) {
                    echo 1;
                    die;
                }
            }

            if ($house_status == 4) {

                Yii::$app->db->createCommand("UPDATE `house_search` set  online = 0  WHERE  house_id = {$house_id}")->execute();
                $lbsid = Yii::$app->db->createCommand("select lbs_id from `house_details` WHERE  id = {$house_id}")->queryScalar();

                $url = JavaUrl . "/api/gd/dellbs";
                $url1 = JavaUrl . "/api/solr/updatesolrbyhouseidnew/$house_id";

                $data = [
                    'lbsid' => $lbsid,
                    'houseid' => $house_id,
                ];
                $data1 = array(
                    'houseId' => $house_id
                );
                $obj = new Submit();
                AsyncRequestService::send_request($url1, '');
                $bool = $obj->sub_post($url, json_encode($data));
                echo 1;

            }


        }

    }

    //    修改房源状态
    public function actionDrop()
    {

        if (Yii::$app->request->isAjax) {

            $uid = Yii::$app->request->post('data')['id'];
            if (!$uid) {
                echo -1;
                die;

            }
            $house_ids = Yii::$app->db->createCommand("SELECT house_id from `house_search` WHERE uid = {$uid} AND status  = 1 AND  online = 1")->queryColumn();
            if ($house_ids) {
                foreach ($house_ids as $k => $v) {
                    Yii::$app->db->createCommand("UPDATE `house_search` set  online = 0  WHERE  house_id = {$v}")->execute();
                    $lbsid = Yii::$app->db->createCommand("select lbs_id from `house_details` WHERE  id = {$v}")->queryScalar();

                    $url = JavaUrl . "/api/gd/dellbs";
                    $url1 = JavaUrl . "/api/solr/updatesolrbyhouseidnew/" . $v;
                    $data = [
                        'lbsid' => $lbsid,
                        'houseid' => $v,
                    ];
                    $obj = new Submit();
                    $obj->sub_post($url, json_encode($data));
                    $obj->sub_get($url1);

                }
                Yii::$app->db->createCommand("UPDATE USER SET status = 4 WHERE id = {$uid}")->execute();
                echo 1;
                die;
            }
            echo -2;
            die;


        }

    }

    //排序

    public function actionSort()
    {

        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $house_id = $post['house_id'];
            $sort_num = $post['sort_num'];
            $url1 = JavaUrl . "/api/solr/updatesolrbyhouseidnew/" . $house_id;
            $data1 = array(
                'houseId' => $house_id
            );
            $obj = new Submit();
            $bool = Yii::$app->db->createCommand("UPDATE `house_search` set tango_weight = {$sort_num} WHERE  house_id = {$house_id}")->execute();
            $log = $obj->sub_get($url1);
            if ($bool == 1 || $bool == 0) {
                echo 1;
                die;
            }
        }

    }

    //添加评论
    public function actionComment()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $house_id = $post['house_id'];
            $comment_inner = addslashes($post['comment_inner']);
            $uid = Yii::$app->db->createCommand("select id from user order by rand() limit 1")->queryScalar();
            $start_time = time() - 60 * 60 * 24 * 30 * 2;
            $end_time = time();
            $create_time = date('Y-m-d H:i:s', rand($start_time, $end_time));
            $shiwu = \Yii::$app->db->beginTransaction();
            try {
                Yii::$app->db->createCommand("INSERT INTO `comment` set uid = {$uid},obj_id = {$house_id},create_time ='{$create_time}',content = '{$comment_inner}',state =1  ")->execute();
                Yii::$app->db->createCommand("update house_search set comment_count = comment_count + 1  where house_id = {$house_id}  ")->execute();
                $shiwu->commit();
                echo 1;
            } catch (Exception $e) {
                $shiwu->rollBack();
                echo 0;
            }


        }

    }

//    修改房源首页图

    public function actionShowpic($id)
    {
        $id = intval($id);
        $pics = Yii::$app->db->createCommand("SELECT img_url FROM house_img_attr WHERE house_id = {$id}")->queryColumn();
        return $this->render('showpic', ['pics' => $pics]);

    }

    public function actionChangepic()
    {

        if (Yii::$app->request->isAjax) {


            $post = Yii::$app->request->post();
            $house_id = $post['house_id'];
            $img = $post['img'];
            $shiwu = Yii::$app->db->beginTransaction();
            try {
                Yii::$app->db->createCommand("update house_details set cover_img  = '{$img}' where id = {$house_id}  ")->execute();
                Yii::$app->db->createCommand("update house_img_attr set img_first  = 0 where house_id = {$house_id}  ")->execute();
                Yii::$app->db->createCommand("update house_img_attr set img_first  = 1 where house_id = {$house_id} AND img_url = '{$img}' ")->execute();
                $shiwu->commit();
                $url = JavaUrl . "/api/solr/updatesolrbyhouseidnew/" . $house_id;
                $data = array(
                    'houseId' => $house_id
                );
                $obj = new Submit();
                $obj->sub_get($url);
                echo 1;
            } catch (Exception $e) {
                $shiwu->rollBack();
                echo $e;
            }
        }
    }

    public function actionGetcity($id = 0)
    {

        $data = \Yii::$app->db->createCommand("select code,name  from `dt_city` WHERE parent={$id}")->queryAll();
        ?>
        <option value="">请选择城市</option>
        <?php

        foreach ($data as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }
    }

    public function actionGetarea($id = 0)
    {

        $data = \Yii::$app->db->createCommand("select code,name  from `dt_city` WHERE parent={$id}")->queryAll();
        ?>
        <option value="">请选择区域</option>
        <?php

        foreach ($data as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }
    }


    public static function getData($id)
    {
        $date = HouseDetailsController::getDate(date("Y-m-d", time()), date("Y-m-d", time() + 3600 * 24 * 180));
        $tmp = [];
        $stock = [];
        //日常价格
        $price = Yii::$app->db->createCommand("select price from `house_search` WHERE house_id = {$id}")->queryScalar();
        //特殊价格
        $special_price = Yii::$app->db->createCommand("select * from `house_special_price` WHERE house_id = {$id}")->queryAll();
        //周末价格
        $week_price = Yii::$app->db->createCommand("select * from `house_week_price` WHERE house_id = {$id} AND is_delete = 0 ")->queryAll();
        //特殊库存信息
        $stock_sql = "SELECT * FROM `house_stock` WHERE `house_id`={$id}";
        $stock_date = \Yii::$app->db->createCommand($stock_sql)->queryAll();
        //日常库存
        $usual_stock_sql = "SELECT `total_stock` FROM `house_details` WHERE `id`={$id}";
        $usual_stock_data = \Yii::$app->db->createCommand($usual_stock_sql)->queryScalar();
        foreach ($date as $k => $v) {
            $tmp[$v] = $price;
            $stock[$v] = '库存：'.$usual_stock_data;
        }
        //是否存在特殊库存
        if (!empty($stock_date)) {
            foreach ($stock as $kks => $vvs) {
                foreach ($stock_date as $ks => $vs) {
                    if ($vs['date'] == $kks) {
                        if ($vs['surplus_stock'] === '0') {
                            $stock[$kks] = '售罄';
                        } else {
                            $stock[$kks] = '库存：'.$vs['surplus_stock'];
                        }
                    }
                }
            }
        }
        if ($week_price) {
            foreach ($tmp as $kk => $vv) {
                foreach ($week_price as $k => $v) {
                    $week_num = date('N', strtotime($kk));
                    if ($week_num == 7) {
                        $week_num = 0;
                    }
                    if ($week_num == $v['weekday']) {
                        $tmp[$kk] = $v['price'];
                    }
                }
            }
        }

        if ($special_price) {
            foreach ($tmp as $kkk => $vvv) {
                foreach ($special_price as $kkkk => $vvvv) {
                    if ($kkk == $vvvv['price_date']) {
                        $tmp[$kkk] = $vvvv['price'];
                    }
                }
            }
        }
        $result = [
            'price' => $tmp,
            'stock' => $stock
        ];
        return $result;

    }

    public static function getDate($start, $end)
    {
        $dt_start = strtotime($start);
        $dt_end = strtotime($end);
        while ($dt_start <= $dt_end) {
            $arr[] = date('Y-m-d', $dt_start);
            $dt_start = strtotime('+1 day', $dt_start);
        }
        return $arr;
    }


    public function actionSalesman()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $data = $_POST;
            $id = $data['data']['keys'];
            $name = $data['data']['name'];
            if (is_array($id)) {
                foreach ($id as $k => $v) {
                    $model = HouseDetails::findOne($v);
                    $model->salesman = $name;
                    $model->save(false);

                }


            }
            echo 1;

        }
    }

    /*
     * 批量下架房源
     * author:snowno
     * date:20171027
     * */
    public function actionPutoffStatus(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $house_ids = trim($data['house_id_str'],',');
            $params_part = $data['params_part'];
            $params = [];
            $params_part_str = '';
            $query_search_notnull = [];
            $key_arr['HouseDetailsQuery'] = [];
            foreach ($params_part as $k=>$v){
                $p = explode('=',$v);
                $key = str_replace('HouseDetailsQuery[','',$p[0]);
                $key = str_replace(']','',$key);
                $key_arr['HouseDetailsQuery'][$key] = $p[1];
                $params_part_str .= $v.',';
                if($p[1] != ''){
                    $query_search_notnull[$p[0]] = $p[1];
                }
            }
            if(empty($query_search_notnull)){
                $query_search_notnull = '';
            }else{
                $query_search_notnull = json_encode($query_search_notnull);
            }

            // 1 批量修改状态
            // 2 记录修改数据
            // 3 调用java接口对高德云数据做相应的删除和更新(20171101与java app端确认 停止操作高德云)
            // 4.修改更新时间
            try{
                $trans = Yii::$app->db->beginTransaction();
                $searchModel = new HouseDetailsQuery();
                $dataProvider = $searchModel->mutisearch($key_arr);
                $model = $dataProvider->getModels();
                $ids = '';
                $lbs_id = [];

                foreach ($model as $v) {
                    if($v->houseserach->status == 1 && $v->houseserach->online == 1){
                        $ids .= $v->id.',';
                        $lbs_id[$v->id] = $v->lbs_id;
                    }
                }

                $ids = trim($ids,',');
                if(!$ids){
                    throw new \yii\db\Exception('所选暂无线上房源可执行下线操作');
                }
                $house_id_arr = explode(',',$ids);
                $update_sql = Yii::$app->db->createCommand("UPDATE `house_search` set  online = 0 WHERE  house_id in({$ids})")->getRawSql();
                $house_search_sql = Yii::$app->db->createCommand("UPDATE `house_search` set  online = 0 WHERE  house_id in({$ids})");

                $house_search = $house_search_sql->execute();
                $uid = Yii::$app->user->getId();
                //修改house_details更新时间
                $current_date = date("Y-m-d H:i:s",time());
                $house_details_sql = Yii::$app->db->createCommand("UPDATE `house_details` set  update_date =  '{$current_date}' WHERE  id in({$ids})")->execute();

                if($house_search){
                    //操作日志记录
                    $date = date('Y-m-d H:i:s',time());
                    $batch = Yii::$app->db->createCommand("insert into  `house_batch_update_status` set  create_time='{$date}',update_sql = :update_sql,admin_uid =:admin_uid,search_query =:search_query,update_house_id_str = :update_house_id_str,search_query_notnull=:search_query_notnull,update_type=:update_type ");
                    $batch->bindValue(':update_sql', htmlspecialchars($update_sql));
                    $batch->bindValue(':admin_uid', $uid);
                    $batch->bindValue(':search_query', $params_part_str);
                    $batch->bindValue(':update_house_id_str', $ids);
                    $batch->bindValue(':search_query_notnull', $query_search_notnull);
                    $batch->bindValue(':update_type', 2)->execute();
                    //solr相应的处理
                    /*$url = JavaUrl . "/api/gd/dellbs";
//                    $lbs_id_arr = explode(',',$lbs_id);
                    if(is_array($lbs_id)){
                        $obj = new Submit();
                        foreach($lbs_id as $house_id=>$lbsid){
                            $url1 = JavaUrl . "/api/solr/updatesolrbyhouseidnew/".$house_id;
                            AsyncRequestService::send_request($url1, '');
                            if($lbsid != 0){
                                $data = [
                                    'lbsid' => $lbsid,
                                    'houseid' => $house_id,
                                ];
                                $bool = $obj->sub_post($url, json_encode($data));
                                if($bool['code'] != 0){
                                    throw new Exception('dellbs error');
                                }
                            }
                        }

                    }else{
                        throw new Exception('lbs_id error');
                    }*/

                    $obj = new Submit();
                    $url = JavaUrl . "/api/solr/removeSolrData";
                    $bool = $obj->sub_post_arr($url, json_encode($house_id_arr));
//                    if($bool == 'success'){
                        $trans->commit();
                        $return['status'] = 1;
                        return json_encode($return);
//                    }else{
//                        throw new Exception($bool);
//                    }
                }else{
                    throw new Exception('update error');
                }
            }catch(Exception $e){
                $err_msg = $e->getMessage();
                $trans->rollBack();
                $return['status'] = 2;
                $return['msg'] = $err_msg;
                return json_encode($return);
            }
        }
    }

    /*
     * 所选下架
     * */
    public function actionPutoffSingleStatus(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $hid_str = trim($data['hid_str'],',');
            $trans = Yii::$app->db->beginTransaction();
            $lbs_id = [];

            try{
                if($hid_str){
                    // 0 过滤出过来的数据中有效数据（已上架条件）
                    // 1 批量修改状态
                    // 2 记录修改数据
                    // 3 调用java接口对高德云数据做相应的删除和更新

                    //0
                    $hid_str = HouseSearch::getFileterHid($hid_str);

                    $update_sql = Yii::$app->db->createCommand("UPDATE `house_search` set  online = 0 WHERE  house_id in({$hid_str})")->getRawSql();
                    $house_update_sql = Yii::$app->db->createCommand("UPDATE `house_search` set  online = 0 WHERE  house_id in({$hid_str})");
                    //修改house_details更新时间
                    $current_date = date("Y-m-d H:i:s",time());
                    $house_search = $house_update_sql->execute();
                    $house_details_sql = Yii::$app->db->createCommand("UPDATE `house_details` set  update_date = '{$current_date}' WHERE  id in({$hid_str})")->execute();

                    $uid = Yii::$app->user->getId();
                    $hid_arr = explode(',',$hid_str);
                    $arr = [];
                    foreach($hid_arr as $k=>$v){
                        $arr['HouseDetailsQuery[house_id]'][] = $v;
                    }
                    $hid_json = json_encode($arr);
                    if($house_search){
                        //操作日志记录
                        $date = date('Y-m-d H:i:s',time());
                        $batch = Yii::$app->db->createCommand("insert into  `house_batch_update_status` set  create_time='{$date}',update_sql = :update_sql,admin_uid =:admin_uid,search_query =:search_query,update_house_id_str = :update_house_id_str,search_query_notnull=:search_query_notnull,update_type=:update_type ");
                        $batch->bindValue(':update_sql', htmlspecialchars($update_sql));
                        $batch->bindValue(':admin_uid', $uid);
                        $batch->bindValue(':search_query', $hid_str);
                        $batch->bindValue(':update_house_id_str', $hid_str);
                        $batch->bindValue(':search_query_notnull', $hid_json);
                        $batch->bindValue(':update_type', 2)->execute();
                        //solr相应的处理 与java沟通后高德云图操作停止
                        /*$house_lbs = Yii::$app->db->createCommand("select id,lbs_id from house_details where id in($hid_str)")->queryAll();
                        if(!empty($house_lbs)){
                            foreach($house_lbs as $k=>$v){
                                $lbs_id[$v->id] = $v->lbs_id;
                            }
                        }*/
                        /*$url = JavaUrl . "/api/gd/dellbs";
//                        $lbs_id_arr = explode(',',$lbs_id);
                        if(is_array($lbs_id)){
                            $obj = new Submit();
                            foreach($lbs_id as $house_id=>$lbsid){
                                $url1 = JavaUrl . "/api/solr/updatesolrbyhouseidnew/".$house_id;
                                AsyncRequestService::send_request($url1, '');
                                if($lbsid != 0){
                                    $data = [
                                        'lbsid' => $lbsid,
                                        'houseid' => $house_id,
                                    ];
                                    $bool = $obj->sub_post($url, json_encode($data));
                                    if($bool['code'] != 0){
                                        throw new Exception('dellbs error');
                                    }
                                }
                            }
                        }*/

                        $obj = new Submit();
                        $url = JavaUrl . "/api/solr/removeSolrData";
                        $bool = $obj->sub_post_arr($url, json_encode($hid_arr));
//                        if($bool == 'success'){
                            $trans->commit();
                            $return['status'] = 1;
                            return json_encode($return);
//                        }else{
//                            throw new Exception($bool);
//                        }

                    }else{
                        throw new Exception('update error');
                    }
                }else{
                    throw new \yii\db\Exception('无有效房源');
                }
            }catch(\yii\db\Exception $e){
                $err = $e->getMessage();
                $trans->rollBack();
                $return['status'] = 2;
                $return['msg'] = $err;
                return json_encode($return);
            }
        }
    }


    public function actionDoRecover(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
//            var_dump($data);exit;
            if($data['hid_str'] && $data['id']){
                //增加恢复数据 并修改下线操作状态 并操作高德solr
                $uid = Yii::$app->user->getId();
                try{
                    $trans = Yii::$app->db->beginTransaction();
                    $hid_str = $data['hid_str'];
                    $hid_arr = explode(',',$hid_str);
                    $id = $data['id'];
                    if(empty($hid_str)){
                        throw new \yii\db\Exception('房源id不存在');
                    }
                    //操作上线
                    $update_sql = Yii::$app->db->createCommand("UPDATE `house_search` set  online = 1 WHERE  house_id in({$hid_str})")->getRawSql();
                    $house_update_sql = Yii::$app->db->createCommand("UPDATE `house_search` set  online = 1 WHERE  house_id in({$hid_str})")->execute();
                    //修改house_details更新时间
                    $current_date = date("Y-m-d H:i:s",time());
                    $house_details_sql = Yii::$app->db->createCommand("UPDATE `house_details` set  update_date =  '{$current_date}' WHERE  id in({$hid_str})")->execute();
                    //操作solr
                    if(empty($hid_arr)){
                        throw new \yii\db\Exception('房源id不存在');
                    }

                    /*$url1 = JavaUrl . "/api/gd/addlbs";
                    $obj = new Submit();
                    foreach($hid_arr as $k => $v){
                        $url = JavaUrl . "/api/solr/updatesolrbyhouseidnew/$v";
                        //查询房源名称 出租方式 价格 经度 纬度 高德云id
                        $house_details = \backend\models\HouseDetails::getDetailsByHid($v);
                        $data = array(
                            'houseid' => $v,
                            'title' => $house_details->title,
                            'roommode' => $house_details->houseserach->roommode,
                            'price' => $house_details->houseserach->price,
                            'longitude' => $house_details->longitude,
                            'latitude' => $house_details->latitude,
                            'lbsid' => $house_details->lbs_id,
                        );

                        AsyncRequestService::send_request($url, '');
                        $return_data = $obj->sub_post($url1, json_encode($data));
                        if($return_data['code'] != 0){
                            throw new \yii\db\Exception('插入更新高的云图数据失败并回滚');
                        }
                    }*/


                    $old_batch = HouseBatchUpdateStatus::findOne($id);
                    $old_batch->status = 1;
                    $old_batch_update = $old_batch->save();
//                    var_dump($old_batch_update);exit;
                    if(!$old_batch_update){
                        throw new \yii\db\Exception('更新操作状态失败回滚');
                    }
                    //操作日志
                    $update_sql = htmlspecialchars($update_sql);
                    $date  = date('Y-m-d H:i:s',time());
                    $batch = Yii::$app->db->createCommand("insert into  `house_batch_update_status` set  create_time='{$date}',update_sql = :update_sql,admin_uid =:admin_uid,update_house_id_str = :update_house_id_str,update_type=:update_type ");
                    $batch->bindValue(':update_sql', $update_sql);
                    $batch->bindValue(':admin_uid', $uid);
                    $batch->bindValue(':update_house_id_str', $hid_str);
                    $batch->bindValue(':update_type', 1);
                    $batch->execute();
                    if(!$batch){
                        throw new \yii\db\Exception('添加操作记录失败回滚');
                    }
                    $trans->commit();

                    $obj = new Submit();
                    $url = JavaUrl . "/api/push/removeHouseToSolr";
                    $bool_json = $obj->sub_post($url, json_encode($hid_arr));
//                    if($bool_json['code'] == '0'){

                        $return['status'] = 1;
                        return json_encode($return);
//                    }else{
//                        throw new Exception($bool_json['msg']);
//                    }

                    /*$trans->commit();
                    $return['status'] = 1;
                    $return['id'] = $id;
                    return json_encode($return);*/
                }catch(\yii\db\Exception $e){
                    //增加错误日志记录
                    $err_msg = $e->getMessage();
                    $trans->rollBack();
                    $return['status'] = 2;
                    $return['msg'] = $err_msg;
                    return json_encode($return);
                }
            }
        }
    }

    public function actionViewdown(){
        $params_id = Yii::$app->request->get('batch_id');
        $p = [];

        if($params_id){
            $hids = HouseBatchUpdateStatus::find()->select('update_house_id_str')->where(['id' => $params_id])->one();
            $p['HouseDetailsQuery']['house_id'] = $hids['update_house_id_str'];
            $searchModel = new HouseDetailsQuery();
            $dataProvider = $searchModel->search($p);
            return $this->render('viewdown',['dataProvider' => $dataProvider]);
        }
    }


}
