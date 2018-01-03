<?php
namespace backend\controllers;
use backend\models\Submit;
use backend\service\CommonService;
use yii\base\Exception;
use yii\web\Controller;
use Yii;
class HouseController extends Controller
{
    public function actionUpdateOne()
    {
        if (Yii::$app->request->isAjax) {
            $title = Yii::$app->request->post('title');
            $roommode = Yii::$app->request->post('roommode');
            $type = Yii::$app->request->post('roomtype');
            $roomsize = Yii::$app->request->post('roomsize');
            $maxguest = Yii::$app->request->post('maxguest');
            $minguest = Yii::$app->request->post('minguest');
            $shi = Yii::$app->request->post('roomnum');
            $ting = Yii::$app->request->post('officenum');
            $chu = Yii::$app->request->post('kitchenum');
            $wei = Yii::$app->request->post('bathnum');
            $yang = Yii::$app->request->post('balconynum');
            $bed_long = Yii::$app->request->post('bed_long');
            $bed_wide = Yii::$app->request->post('bed_wide');
            $bed_count = Yii::$app->request->post('bed_count');
            $bed_type = Yii::$app->request->post('bed_type');
            $total_stock = Yii::$app->request->post('total_stock');
            $time_zone = Yii::$app->request->post('time_zone');
            $national = Yii::$app->request->post('national');
            $province = Yii::$app->request->post('province');
            $city = Yii::$app->request->post('city');
            $area = Yii::$app->request->post('area');
            $vague_addr = Yii::$app->request->post('vague_addr');
            $biotope = Yii::$app->request->post('address');
            $latitude = Yii::$app->request->post('latitude');
            $longitude = Yii::$app->request->post('longitude');
            $doornum = Yii::$app->request->post('doornum');
            $house_id = Yii::$app->request->post('house_id');
            $full_address=Yii::$app->request->post('full_address');
            if (empty($title) || empty($type) || empty($roommode) || empty($roomsize) || empty($maxguest) || empty($minguest) || empty($total_stock) || empty($national) || empty($province) || empty($city) || empty($biotope) || empty($latitude) || empty($longitude) || empty($house_id)) {
                echo 0;
                die;
            }
            if ($national == 10001 || $national == 10002 || $national == 10003) {
                if (empty($area)) {
                    echo -5;
                    die;
                }
            }
            if ($shi == 0 && $ting == 0 && $chu == 0 && $wei == 0 && $yang == 0) {
                echo -1;
                die;
            }
            $bed_long = explode(',', $bed_long);
            $bed_wide = explode(',', $bed_wide);
            $bed_count = explode(',', $bed_count);
            $bed_type = explode(',', $bed_type);
            $bed_total_count = array_sum($bed_count);
            foreach ($bed_long as $k => $v) {
                if (empty($v)) {
                    echo -2;
                    die;
                }
            }
            foreach ($bed_wide as $k => $v) {
                if (empty($v)) {
                    echo -2;
                    die;
                }
            }
            foreach ($bed_count as $k => $v) {
                if (empty($v)) {
                    echo -2;
                    die;
                }
            }
            $data = [
                'title' => $title,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'biotope' => $biotope,
                'vague_addr' => $vague_addr,
                'doornum' => $doornum,
                'roomsize' => $roomsize,
                'total_stock' => $total_stock,
                'time_zone' => $time_zone,
                'address'=>$full_address
            ];
            $old_data = Yii::$app->db->createCommand("select title,old_hid,address,biotope,longitude,latitude,lbs_id,house_addr_id,up_type from house_details WHERE id=$house_id")->queryOne();
            $old_search = Yii::$app->db->createCommand("select status,online,roommode,step_one,step_two,step_three,step_four from house_search WHERE house_id=$house_id")->queryOne();
            $old_status = $old_search['status'];
            $old_online = $old_search['online'];
            $old_roommode = $old_search['roommode'];
            if ($old_data['old_hid'] > 0) {
                if ($biotope != $old_data['address'] || $old_data['title'] != $title || $old_data['longitude'] != $longitude || $old_data['latitude'] != $latitude || $old_roommode != $roommode) {
                    if($old_data['up_type']==2){
                        if ($old_search['step_one'] == 1 && $old_search['step_two'] == 1 && $old_search['step_three'] == 1 && $old_search['step_four'] == 1) {
                            $status = 0;
                        } else {
                            $status = -1;
                        }
                    }else{
                        $status=0;
                    }
                    $online = 0;
                } else {
                    if ($old_status == 1) {
                        $status = 1;
                        $online = $old_online;
                    } else {
                        if($old_data['up_type']==2){
                            if ($old_search['step_one'] == 1 && $old_search['step_two'] == 1 && $old_search['step_three'] == 1 && $old_search['step_four'] == 1) {
                                $status = 0;
                            } else {
                                $status = -1;
                            }
                        }else{
                            $status=$old_search['status'];
                        }
                        $online = 0;
                    }
                }
            } else {
                if ($biotope != $old_data['biotope'] || $old_data['title'] != $title || $old_data['longitude'] != $longitude || $old_data['latitude'] != $latitude || $old_roommode != $roommode) {
                    if($old_data['up_type']==2){
                        if ($old_search['step_one'] == 1 && $old_search['step_two'] == 1 && $old_search['step_three'] == 1 && $old_search['step_four'] == 1) {
                            $status = 0;
                        } else {
                            $status = -1;
                        }
                    }else{
                        $status=0;
                    }
                    $online = 0;
                } else {
                    if ($old_status == 1) {
                        $status = 1;
                        $online = $old_online;
                    } else {
                        if($old_data['up_type']==2){
                            if ($old_search['step_one'] == 1 && $old_search['step_two'] == 1 && $old_search['step_three'] == 1 && $old_search['step_four'] == 1) {
                                $status = 0;
                            } else {
                                $status = -1;
                            }
                        }else{
                            $status=$old_search['status'];
                        }
                        $online = 0;
                    }
                }
            }
            $address_data = [
                'national' => $national,
                'address' => $biotope,
                'vague_addr' => $vague_addr,
                'doornum' => $doornum,
                'province' => $province,
                'city' => $city,
                'area' => $area,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'time_zone' => $time_zone,
            ];
            $shiwu = Yii::$app->db->beginTransaction();
            try {
                Yii::$app->db->createCommand()->update('house_address', $address_data, ['id' => $old_data['house_addr_id']])->execute();
                Yii::$app->db->createCommand()->update('house_details', $data, ['id' => $house_id])->execute();
                $house_search_data = [
                    'house_id' => $house_id,
                    'maxguest' => $maxguest,
                    'roommode' => $roommode,
                    'roomtype' => $type,
                    'roomnum' => $shi ? $shi : 0,
                    'officenum' => $ting ? $ting : 0,
                    'bathnum' => $wei ? $wei : 0,
                    'kitchenum' => $chu ? $chu : 0,
                    'balconynum' => $yang ? $yang : 0,
                    'province' => $province,
                    'city' => $city,
                    'area' => $area,
                    'national' => $national,
                    'minguest' => $minguest,
//                    'tango_weight' => $tango_weight,
//                    'to_top' => $to_top,
//                    'top_start' => $top_start,
//                    'top_end' => $top_end,
                    'status' => $status,
                    'bedcount' => $bed_total_count,
                    'online' => $online,
                    'step_one' => 1
                ];
                Yii::$app->db->createCommand()->update('house_search', $house_search_data, ['house_id' => $house_id])->execute();
                foreach ($bed_type as $k => $v) {
                    $bed_data[] = [
                        'bed_type' => $v,
                        'bed_long' => $bed_long[$k],
                        'bed_wide' => $bed_wide[$k],
                        'bed_count' => $bed_count[$k],
                        'house_id' => $house_id
                    ];
                }
                Yii::$app->db->createCommand("delete from house_beds WHERE house_id=$house_id")->execute();
                foreach ($bed_data as $k => $v) {
                    Yii::$app->db->createCommand("insert into house_beds(bed_long,bed_wide,bed_type,bed_count,house_id) VALUES ({$v['bed_long']},{$v['bed_wide']},{$v['bed_type']},{$v['bed_count']},{$v['house_id']})")->execute();
                }
                $shiwu->commit();
                if ($old_status == 1) {
                    $url1 = JavaUrl . "/api/push/pushsolr";
                    $data1 = array(
                        'houseId' => $house_id
                    );
                    $obj = new Submit();
                    $obj->sub_post($url1, json_encode($data1));
                }
                if ($old_status == 1 && $status == 0) {
                    $lbsid = $old_data['lbs_id'];
                    $url = JavaUrl . "/api/gd/dellbs";
                    $data = [
                        'lbsid' => $lbsid,
                        'houseid' => $house_id,
                    ];
                    $obj = new Submit();
                    $bool = $obj->sub_post($url, json_encode($data));
                }
                echo $house_id;
                die;
            } catch (Exception $e) {
                $shiwu->rollBack();
                echo -3;
                die;
            }
        }
        if (isset($_GET['house_id'])) {
            $house_type = Yii::$app->db->createCommand("select * from dt_house_type_code")->queryAll();
            $house_id = Yii::$app->request->get('house_id');
            $uid = Yii::$app->db->createCommand("select uid from house_details WHERE id=$house_id")->queryScalar();
            $house_status = Yii::$app->db->createCommand("select status from house_search WHERE house_id = {$house_id}")->queryScalar();
            $mobile = Yii::$app->db->createCommand("select mobile from user WHERE id=$uid")->queryScalar();
            $house_bed = Yii::$app->db->createCommand("select * from house_beds WHERE house_id=$house_id")->queryAll();
            $old_data = Yii::$app->db->createCommand("select h.id,h.vague_addr,h.total_stock,h.title,h.longitude,h.latitude,h.address,h.biotope,h.doornum,h.minday,h.maxday,h.roomsize,s.roommode,s.roomtype,s.roomnum,s.officenum,s.bathnum,s.kitchenum,s.balconynum,s.national,s.province,s.city,s.area,s.minguest,s.to_top,s.top_start,s.top_end,s.old_hid,s.maxguest,s.tango_weight,dt_house_type.code from house_details as h JOIN house_search as s ON h.id=s.house_id LEFT JOIN dt_house_type on s.roomtype = dt_house_type.id WHERE h.id=$house_id")->queryOne();
            $house_error = Yii::$app->db->createCommand("select * from house_audit_log WHERE result=0 AND house_id=$house_id")->queryOne();
            return $this->render('update-one', ['house_data' => $old_data, 'house_type' => $house_type, 'host' => $_SERVER['HTTP_HOST'], 'house_bed' => $house_bed, 'mobile' => $mobile, 'house_error' => $house_error, 'status' => $house_status]);
        } else {
            return $this->render('error');
        }
    }

    public function actionAddTwo()
    {
        if (!isset($_GET['house_id'])) {
            return $this->render('error');
        }
        $house_id = $_GET['house_id'];
        $is_guowai = Yii::$app->db->createCommand("select `national` from house_search WHERE house_id=$house_id")->queryScalar();
        if ($is_guowai == 10001) {
            $is_guowai = 1;
        } else {
            $is_guowai = 0;
        }
        if ($house_id > 0) {
            $price = Yii::$app->db->createCommand("select price from house_search WHERE house_id=$house_id")->queryScalar();
            if ($price) {
                $date_data = $this->getData($house_id);
                $status = 1;
            } else {
                $date_data = [];
                $price = '';
                $status = 0;
            }
        } else {
            $price = '';
            $status = 0;
        }
        $scale_status = Yii::$app->db->createCommand("select is_scale from house_details WHERE id=$house_id")->queryScalar();
        $deposit = Yii::$app->db->createCommand("select deposit from house_details WHERE id=$house_id")->queryScalar();
        if ($scale_status == 1) {
            $scale = Yii::$app->db->createCommand("select * from house_commision WHERE house_id=$house_id")->queryOne();
            $old_scale = $scale['commision'];
            if ($is_guowai == 0) {
                if ($price) {
                    $haiwai_sell_price = $price * (1 + $old_scale / 100);
                } else {
                    $haiwai_sell_price = '';
                }
            }
        } else {
            $scale = [];
            if ($is_guowai == 1) {
                $old_scale = Yii::$app->db->createCommand("select scale_value from commission_default WHERE type=1 AND is_default=1")->queryScalar();
            } else {
                $old_scale = Yii::$app->db->createCommand("select scale_value from commission_default WHERE type=2 AND is_default=1")->queryScalar();
                if ($price) {
                    $haiwai_sell_price = $price * (1 + $old_scale / 100);
                } else {
                    $haiwai_sell_price = '';
                }
            }
        }
        if ($is_guowai == 0) {
            $old_house_data = Yii::$app->db->createCommand("select clean_fee,is_over_fee,over_fee from house_details WHERE id=$house_id")->queryOne();
        } else {
            $old_house_data = [];
        }
        $house_error = Yii::$app->db->createCommand("select * from house_audit_log WHERE result=0 AND house_id=$house_id")->queryOne();
        $yongjin_list = Yii::$app->db->createCommand("select * from commission_default WHERE type=1 AND is_default=0")->queryAll();
        $haiwai_list = Yii::$app->db->createCommand("select * from commission_default WHERE type=2 AND is_default=0")->queryAll();
        $max_num = Yii::$app->db->createCommand("select maxguest from house_search WHERE house_id=$house_id")->queryScalar();
        return $this->render('add-two', ['price_status' => $status, 'max_num' => $max_num, 'old_house_data' => $old_house_data, 'haiwai_sell_price' => $haiwai_sell_price, 'old_scale' => $old_scale, 'yongjin_list' => $yongjin_list, 'haiwai_list' => $haiwai_list, 'scale' => $scale, 'scale_status' => $scale_status, 'price' => $price, 'date_data' => $date_data, 'is_guowai' => $is_guowai, 'house_error' => $house_error, 'deposit' => $deposit]);
    }

    public function actionAddPrice()
    {
        if (Yii::$app->request->isAjax) {
            $price = Yii::$app->request->post('price');
            $house_id = Yii::$app->request->post('house_id');
            $old_price = Yii::$app->db->createCommand("select price from house_search WHERE house_id=$house_id")->queryScalar();
            if (empty($price) || empty($house_id)) {
                $arr = [
                    'status' => 0,
                    'msg' => '价格有误',
                    'old_price' => $old_price ? $old_price : 0
                ];
                echo json_encode($arr);
                die;
            }
            $preg = '/^\d+(.\d{1})?$/';
            $bool = preg_match($preg, $price);
            if (!$bool) {
                $arr = [
                    'status' => 0,
                    'msg' => '价格格式有误',
                    'old_price' => $old_price ? $old_price : 0
                ];
                echo json_encode($arr);
                die;
            }
            Yii::$app->db->createCommand("update house_search set price=$price WHERE house_id=$house_id")->execute();
            $old_status = Yii::$app->db->createCommand("select status from house_search WHERE house_id=$house_id")->queryScalar();
            if ($old_status == 1) {
                if ($old_price != $price) {
                    $lbs_id = Yii::$app->db->createCommand("select lbs_id from house_details WHERE id=$house_id")->queryScalar();
                    $url = JavaUrl . "/api/gd/dellbs";
                    $data = [
                        'lbsid' => $lbs_id,
                        'houseid' => $house_id,
                    ];
                    $obj = new Submit();
                    $bool = $obj->sub_post($url, json_encode($data));
                    //添加solar同步操作
                    $url_2 = JavaUrl . "/api/solr/updatesolrbyhouseidnew/".$house_id;
                    $obj->sub_get($url_2);
                }
            }
            $arr = [
                'status' => 1,
                'msg' => '修改成功',
                'old_price' => $old_price ? $old_price : 0
            ];
            echo json_encode($arr);
            die;
        }
    }

    public function actionAddStock()
    {
        if (Yii::$app->request->isAjax) {
            $start = Yii::$app->request->post('start_time');
            $end = Yii::$app->request->post('end_time');
            $house_id = Yii::$app->request->post('house_id');
            $num = Yii::$app->request->post('num');
            $status = Yii::$app->request->post('status');
            $stock = Yii::$app->db->createCommand("select total_stock from house_details WHERE id=$house_id")->queryScalar();
            if (empty($start) || empty($end) || empty($house_id)) {
                echo -1;
                die;
            }
            $date_arr = CommonService::getDate($start, $end);
            if (!empty($date_arr)) {
                foreach ($date_arr as $k => $v) {
                    if ($stock != $num && $num >= 0) {
                        $old_data = Yii::$app->db->createCommand("select * from house_stock WHERE house_id=$house_id AND `date`='{$v}'")->queryOne();
                        if ($old_data) {
                            Yii::$app->db->createCommand("update house_stock set surplus_stock=$num WHERE house_id=$house_id AND `date`='{$v}'")->execute();
                        } else {
                            Yii::$app->db->createCommand("insert into house_stock(house_id,date,surplus_stock) VALUES ($house_id,'{$v}',$num)")->execute();
                        }
                    }
                    $old_status = Yii::$app->db->createCommand("select * from house_disable_date WHERE house_id=$house_id AND disable_date='{$v}'")->queryOne();
                    if ($status == 1) {
                        if ($old_status) {
                            Yii::$app->db->createCommand("delete from house_disable_date WHERE id={$old_status['id']}")->execute();
                        }
                    } else {
                        if (!$old_status) {
                            Yii::$app->db->createCommand("insert into house_disable_date(house_id,disable_date) VALUES ($house_id,'{$v}')")->execute();
                        }
                    }
                }
                echo 1;
                die;
            }
        }
    }

    public function actionBatchPrice()
    {
        if (Yii::$app->request->isAjax) {
            $house_id = Yii::$app->request->post('house_id');
            $start_time = Yii::$app->request->post('start_time');
            $end_time = Yii::$app->request->post('end_time');
            $price = Yii::$app->request->post('price');
            $old_price = Yii::$app->db->createCommand("select price from house_search WHERE house_id=$house_id")->queryScalar();
            if (empty($house_id) || empty($start_time) || empty($end_time) || empty($price)) {
                echo -1;
                die;
            }
            $preg = '/^\d+(.\d{1})?$/';
            $bool = preg_match($preg, $price);
            if (!$bool) {
                echo -2;
                die;
            }
            $date_arr = CommonService::getDate($start_time, $end_time);
            if (!empty($date_arr) && $price != $old_price) {
                foreach ($date_arr as $k => $v) {
                    $old_data = Yii::$app->db->createCommand("select * from house_special_price WHERE house_id=$house_id AND price_date='{$v}'")->queryOne();
                    if ($old_data) {
                        Yii::$app->db->createCommand("update house_special_price set price={$price} WHERE house_id=$house_id AND price_date='{$v}'")->execute();
                    } else {
                        Yii::$app->db->createCommand("insert into house_special_price(house_id,price_date,price) VALUES ($house_id,'{$v}',$price)")->execute();
                    }
                }
                echo 1;
                die;
            }
        }
    }

    public function actionWeekPrice()
    {
        if (Yii::$app->request->isAjax) {
            $house_id = Yii::$app->request->post('house_id');
            $price = Yii::$app->request->post('price');
            $week = Yii::$app->request->post('week');
            if (empty($house_id) || empty($price) || $week == '') {
                echo -1;
                die;
            }
            $preg = '/^\d+(.\d{1})?$/';
            $bool = preg_match($preg, $price);
            if (!$bool) {
                echo -2;
                die;
            }
            $week_arr = explode(',', $week);
            $special_price = Yii::$app->db->createCommand("select * from house_special_price WHERE house_id=$house_id")->queryAll();
            if (!empty($special_price)) {
                foreach ($special_price as $k => $v) {
                    $week_num = date('N', strtotime($v['price_date']));
                    if ($week_num == 7) {
                        $week_num = 0;
                    }
                    if (in_array($week_num, $week_arr)) {
                        Yii::$app->db->createCommand("delete from house_special_price WHERE id={$v['id']}")->execute();
                    }
                }
            }
            foreach ($week_arr as $k => $v) {
                $old_week = Yii::$app->db->createCommand("select * from house_week_price WHERE house_id=$house_id AND weekday={$v}")->queryOne();
                if ($old_week) {
                    Yii::$app->db->createCommand("update house_week_price set price=$price WHERE id={$old_week['id']}")->execute();
                } else {
                    Yii::$app->db->createCommand("insert into house_week_price(weekday,price,house_id) VALUES ($v,$price,$house_id)")->execute();
                }
            }
            echo 1;
            die;
        }
    }

    public function actionTwoLast()
    {
        if (Yii::$app->request->isAjax) {
            $house_id = Yii::$app->request->post('house_id');
            $refund = Yii::$app->request->post('refund');
            $is_deposit = Yii::$app->request->post('is_deposit');
            $deposit = Yii::$app->request->post('deposit') ? Yii::$app->request->post('deposit') : 0;
            $clean_fee = Yii::$app->request->post('clean_fee') ? Yii::$app->request->post('clean_fee') : 0;
            $is_scale = Yii::$app->request->post('is_scale');
            $scale = Yii::$app->request->post('scale');
            $start_time = Yii::$app->request->post('start_time');
            $end_time = Yii::$app->request->post('end_time');
            $excess_type = Yii::$app->request->post('excess_type');
            $excess = Yii::$app->request->post('excess');
            $bool1 = preg_match("/^[1-9]d*|0$/", $deposit);
            $bool2 = preg_match("/^[1-9]d*|0$/", $clean_fee);
            $national = Yii::$app->db->createCommand("select `national` from house_search WHERE house_id=$house_id")->queryScalar();
            $old_search = Yii::$app->db->createCommand("select status,online,roommode,step_one,step_two,step_three,step_four,status from house_search WHERE house_id=$house_id")->queryOne();
            $old_type=Yii::$app->db->createCommand("select up_type from house_details WHERE id=$house_id")->queryScalar();
            if ($is_deposit == 0) {
                $deposit = 0;
            } else {
                $deposit = $deposit;
            }
            if (empty($house_id) || empty($refund)) {
                echo -1;
                die;
            }
            if ($national != 10001) {
                if (!$bool2) {
                    echo -2;
                    die;
                }
            } else {
                if (!$bool1) {
                    echo -2;
                    die;
                }
            }
            if($old_type==2){
                if ($old_search['step_one'] == 1 && $old_search['step_three'] == 1 && $old_search['step_four'] == 1) {
                    $status = 0;
                } else {
                    $status = -1;
                }
            }else{
                $status=$old_search['status'];
            }
            $shiwu = Yii::$app->db->beginTransaction();
            try {
                if ($national == 10001) {
                    if ($is_scale == 1) {
                        $bool = Yii::$app->db->createCommand("update house_details set refund_rule=$refund,deposit={$deposit},is_deposit={$is_deposit},is_scale=1 WHERE id=$house_id")->execute();
                        $old_scale = Yii::$app->db->createCommand("select * from house_commision WHERE house_id=$house_id AND type=0")->queryOne();
                        if ($old_scale) {
                            Yii::$app->db->createCommand("update house_commision set commision=$scale,start_time='{$start_time}',end_time='{$end_time}' WHERE id={$old_scale['id']}")->execute();
                        } else {
                            Yii::$app->db->createCommand("insert into house_commision(house_id,commision,start_time,end_time,type) VALUES ($house_id,$scale,'{$start_time}','{$end_time}',0)")->execute();
                        }
                    } else {
                        $old_scale = Yii::$app->db->createCommand("select * from house_commision WHERE house_id=$house_id AND type=0")->queryOne();
                        if ($old_scale) {
                            Yii::$app->db->createCommand("delete from house_commision WHERE id={$old_scale['id']}")->execute();
                            Yii::$app->db->createCommand("update house_details set is_scale=0 WHERE id={$house_id}")->execute();
                        }
                        $bool = Yii::$app->db->createCommand("update house_details set refund_rule=$refund,deposit={$deposit},is_deposit={$is_deposit} WHERE id=$house_id")->execute();
                    }
                    Yii::$app->db->createCommand("update house_search set status=$status,step_two=1 WHERE house_id=$house_id")->execute();
                } else {
                    if ($is_scale == 1) {
                        $bool = Yii::$app->db->createCommand("update house_details set refund_rule=$refund,deposit={$deposit},is_deposit={$is_deposit},clean_fee={$clean_fee},over_fee={$excess},is_over_fee={$excess_type},is_scale=1 WHERE id=$house_id")->execute();
                        $old_scale = Yii::$app->db->createCommand("select * from house_commision WHERE house_id=$house_id AND type=1")->queryOne();
                        if ($old_scale) {
                            Yii::$app->db->createCommand("update house_commision set commision=$scale,start_time='{$start_time}',end_time='{$end_time}' WHERE id={$old_scale['id']}")->execute();
                        } else {
                            Yii::$app->db->createCommand("insert into house_commision(house_id,commision,start_time,end_time,type) VALUES ($house_id,$scale,'{$start_time}','{$end_time}',1)")->execute();
                        }
                    } else {
                        $old_scale = Yii::$app->db->createCommand("select * from house_commision WHERE house_id=$house_id AND type=1")->queryOne();
                        if ($old_scale) {
                            Yii::$app->db->createCommand("delete from house_commision WHERE id={$old_scale['id']}")->execute();
                            Yii::$app->db->createCommand("update house_details set is_scale=0 WHERE id={$house_id}")->execute();
                        }
                        $bool = Yii::$app->db->createCommand("update house_details set refund_rule=$refund,deposit={$deposit},is_deposit={$is_deposit},clean_fee={$clean_fee},over_fee={$excess},is_over_fee={$excess_type} WHERE id=$house_id")->execute();
                    }
                    Yii::$app->db->createCommand("update house_search set status=$status,step_two=1 WHERE house_id=$house_id")->execute();
                    $obj = new Submit();
                    $java_url = JavaUrl . "/api/solr/updatesolrbyhouseidnew/{$house_id}";
                    $obj->sub_wx_self($java_url);
                }
                $shiwu->commit();
                echo 1;
                die;
            } catch (Exception $e) {
                echo $e->getMessage();
                $shiwu->rollBack();
                echo -3;
                die;
            }
        }
    }

    public function actionAddThree()
    {
        if (Yii::$app->request->isAjax) {
            $house_id = Yii::$app->request->post('house_id');
            $minday = Yii::$app->request->post('minday');
            $maxday = Yii::$app->request->post('maxday');
            $beforday = Yii::$app->request->post('beforeday');
            $intime = Yii::$app->request->post('intime');
            $outtime = Yii::$app->request->post('outtime');
            $sex = Yii::$app->request->post('sex');
            $is_welcome = Yii::$app->request->post('is_welcome');
            $limit = Yii::$app->request->post('limit');
            //admin:ys time:2017/11/10 content:添加民宿预订方式更改功能
            $is_realtime = Yii::$app->request->post('is_realtime',0);
            $secret_notice = addslashes(Yii::$app->request->post('secret_notice'));
            $notice = addslashes(Yii::$app->request->post('notice'));
            if (empty($house_id) || empty($minday) || empty($intime) || empty($outtime) || $beforday == '') {
                echo -1;
                die;
            }
            $bool1 = preg_match("/^[0-9]\d*$/", $minday);
            $bool2 = preg_match("/^[0-9]\d*$/", $maxday);
            $bool3 = preg_match("/^[0-9]\d*$/", $beforday);
            if (!$bool1 || !$bool2 || !$bool3) {
                echo -3;
                die;
            }
            $old_type=Yii::$app->db->createCommand("select up_type from house_details WHERE id=$house_id")->queryScalar();
            //查询出老数据中房源的预订方式（0.需要确认  1.可实时预定）
            $old_is_realtime = Yii::$app->db->createCommand("select is_realtime from house_details WHERE id=$house_id")->queryScalar();
            $old_search = Yii::$app->db->createCommand("select status,online,roommode,step_one,step_two,step_three,step_four from house_search WHERE house_id=$house_id")->queryOne();
            //房源上传平台（0平时上传，特殊上传1  2=>合伙人 3=>PC房东 4.番茄来了 5.同程）
            if($old_type==2){//合伙人上传
                if ($old_search['step_one'] == 1 && $old_search['step_two'] == 1 && $old_search['step_four'] == 1) {// PC上传房源步骤状态  0=>未修改  1=>已修改
                    $status = 0;
                } else {
                    $status = -1;
                }
            }else{//非合伙人平台上传
                $status=$old_search['status'];
            }
            $shiwu = Yii::$app->db->beginTransaction();
            try {
                Yii::$app->db->createCommand("update house_details set minday=$minday,intime=$intime,outtime=$outtime,is_welcome=$is_welcome,secret_notice='{$secret_notice}',notice='{$notice}',maxday=$maxday,beforeday=$beforday,is_realtime={$is_realtime} WHERE id=$house_id")->execute();
                Yii::$app->db->createCommand("update house_search set sex=$sex,status=$status,step_three=1 WHERE house_id=$house_id")->execute();
                if ($limit) {
                    $limit = explode(',', $limit);
                    $old_data = Yii::$app->db->createCommand("select id from house_limit WHERE house_id=$house_id")->queryColumn();
                    if ($old_data) {
                        $limit_id_str = implode(',', $old_data);
                        Yii::$app->db->createCommand("delete from house_limit WHERE id IN ($limit_id_str)")->execute();
                    }
                    foreach ($limit as $k => $v) {
                        Yii::$app->db->createCommand("insert into house_limit(house_id,limit_id) VALUES ($house_id,$v)")->execute();
                    }
                }
                //如果房源的预定方式做了修改，就同步一下solar的房源信息
                if ($old_is_realtime != $is_realtime) {
                    //添加solr同步操作
                    $obj = new Submit();
                    $url_2 = JavaUrl . "/api/solr/updatesolrbyhouseidnew/".$house_id;
                    $obj->sub_get($url_2);
                }
                $shiwu->commit();
                echo 1;
                die;
            } catch (Exception $e) {
                $shiwu->rollBack();
                echo -2;
                die;
            }
        }
        if (!isset($_GET['house_id'])) {
            return $this->render('error');
        }
        $house_id = Yii::$app->request->get('house_id');
        $old_limit = Yii::$app->db->createCommand("select * from house_limit WHERE house_id=$house_id")->queryAll();
        //$old_data = Yii::$app->db->createCommand("select h.minday,h.maxday,h.beforeday,intime,h.outtime,h.is_welcome,h.notice,h.secret_notice,s.sex from house_details as h JOIN house_search as s ON h.id=s.house_id WHERE h.id={$house_id}")->queryOne();
        $old_data = Yii::$app->db->createCommand("select h.minday,h.maxday,h.beforeday,intime,h.outtime,h.is_welcome,h.notice,h.secret_notice,s.sex,h.is_realtime,h.up_type from house_details as h JOIN house_search as s ON h.id=s.house_id WHERE h.id={$house_id}")->queryOne();
//
        $house_error = Yii::$app->db->createCommand("select * from house_audit_log WHERE result=0 AND house_id=$house_id")->queryOne();
        $house_limit = Yii::$app->db->createCommand("select * from dt_house_limit")->queryAll();
        return $this->render('add-three', [
            'house_limit' => $house_limit,
            'house_data' => $old_data,
            'old_limit' => $old_limit,
            'house_error' => $house_error
        ]);
    }

    public function actionSetTitlePic()
    {
        if (Yii::$app->request->isAjax) {
            $house_id = Yii::$app->request->post('house_id');
            $title_pic = Yii::$app->request->post('title_pic');
            if (empty($house_id) || empty($title_pic)) {
                echo -1;
                die;
            }
            echo Yii::$app->db->createCommand("update house_details set cover_img='{$title_pic}' WHERE id=$house_id")->execute();
            die;
        }
    }

    public function actionAddFour()
    {
        if (Yii::$app->request->isAjax) {
            $house_id = Yii::$app->request->post('house_id');
            $pic = Yii::$app->request->post('pic');
            //@2017-11-7 10:24:21 fuyafnei to add minsu320[添加房源图片标签配置]
            $imgLabelStr = Yii::$app->request->post("imgLabelStr");
            $nearby_intro = addslashes(Yii::$app->request->post('nearby_intro'));
            $introduce = addslashes(Yii::$app->request->post('introduce'));
            //@2017-11-7 10:57:54 fuyanfei to add minsu320[添加房源亮点]
            $house_highlights = addslashes(Yii::$app->request->post("house_highlights"));
            $traffic_intro = addslashes(Yii::$app->request->post('traffic_intro'));
            $inside = Yii::$app->request->post('inside');
            //@2017-11-7 18:18:41 fuyanfei to add minsu320[添加房源质量权重计算]
            $house_img = Yii::$app->request->post('house_img');
            $text_description = Yii::$app->request->post('text_description');
            $renovation = Yii::$app->request->post('renovation');
            $bedding = Yii::$app->request->post('bedding');
            $dry_wet = Yii::$app->request->post('dry_wet');
            //------------end-----minsu320[添加房源质量权重计算]
            //@2017-11-7 10:27:31 fuyanfei to add minsu320[添加房源图片标签配置]--- || empty($imgLabelStr)
            if (empty($house_id) || empty($pic) || empty($imgLabelStr) || empty($introduce)) {
                echo -1;
                die;
            }
            if (empty($inside)) {
                echo -3;
                die;
            }
            //@2017-11-7 14:00:00 fuyanfei to add try...catch...  and transcation
            $trans = Yii::$app->db->beginTransaction();
            try{
                $cover_pic = Yii::$app->db->createCommand("select cover_img from house_details WHERE id=$house_id")->queryScalar();
                if (empty($cover_pic)) {
                    echo -2;
                    die;
                }
                $old_type=Yii::$app->db->createCommand("select up_type from house_details WHERE id=$house_id")->queryScalar();
                $old_search = Yii::$app->db->createCommand("select status,online,roommode,step_one,step_two,step_three,step_four from house_search WHERE house_id=$house_id")->queryOne();
                $old_introduce = Yii::$app->db->createCommand("select introduce from house_details WHERE id=$house_id")->queryScalar();
                $old_status = Yii::$app->db->createCommand("select status from house_search WHERE house_id=$house_id")->queryScalar();
                $old_online = Yii::$app->db->createCommand("select online from house_search WHERE house_id=$house_id")->queryScalar();
                $pic = explode(',', $pic);
                //@2017-11-7 10:29:38 fuyanfei to add minsu320[添加房源图片标签配置]
                $imgLabelArr = explode(",",$imgLabelStr);
                //--------------end----------------
                $inside_arr = explode(',', $inside);
                $old_pic = Yii::$app->db->createCommand("select * from house_img_attr WHERE house_id=$house_id")->queryAll();
                $pic_count = count($pic);
                $old_pic_count = Yii::$app->db->createCommand("select count(*) from house_img_attr WHERE house_id=$house_id")->queryScalar();
                if ($old_status != -1) {
                    if ($old_introduce != $introduce || $old_pic_count != $pic_count) {
                        if($old_type==2){
                            if ($old_search['step_one'] == 1 && $old_search['step_two'] == 1 && $old_search['step_three'] == 1) {
                                $status = 0;
                            } else {
                                $status = -1;
                            }
                        }else{
                            $status=0;
                        }
                        $online = 0;
                    } else {
                        if ($old_status == 1) {
                            $status = 1;
                            $online = $old_online;
                        } else {
                            if($old_type==2){
                                if ($old_search['step_one'] == 1 && $old_search['step_two'] == 1 && $old_search['step_three'] == 1) {
                                    $status = 0;
                                } else {
                                    $status = -1;
                                }
                            }else{
                                $status=0;
                            }
                            $online = 0;
                        }
                    }
                } else {
                    if($old_type==2){
                        if ($old_search['step_one'] == 1 && $old_search['step_two'] == 1 && $old_search['step_three'] == 1) {
                            $status = 0;
                        } else {
                            $status = -1;
                        }
                    }else{
                        $status=0;
                    }
                    $online = 0;
                }
                if ($old_pic) {
                    Yii::$app->db->createCommand("delete from house_img_attr WHERE house_id=$house_id")->execute();
                }
                $old_inside = Yii::$app->db->createCommand("select * from house_facilities_inside WHERE house_id=$house_id")->queryAll();
                if ($old_inside) {
                    Yii::$app->db->createCommand("delete from house_facilities_inside WHERE house_id=$house_id")->execute();
                }
                foreach ($inside_arr as $k => $v) {
                    Yii::$app->db->createCommand("insert into house_facilities_inside(house_id,inside_id) VALUES ($house_id,$v)")->execute();
                }
                foreach ($pic as $k => $v) {
                    //@2017-11-7 13:47:25 fuyanfei to add minsu320 [添加图片标签]  添加房源图片时添加图片标签的值
                    $imgLabel = isset($imgLabelArr[$k]) ? $imgLabelArr[$k] : "NULL";
                    Yii::$app->db->createCommand("insert into house_img_attr(img_url,house_id,img_label) VALUES ('{$v}',$house_id,$imgLabel)")->execute();
                }
                //@2017-11-7 11:46:19 fuyanfei to add minsu320[添加房源亮点] 修改语句时添加房源亮点的修改
                Yii::$app->db->createCommand("update house_details set nearby_intro='{$nearby_intro}',introduce='{$introduce}',traffic_intro='{$traffic_intro}',house_highlights='{$house_highlights}' WHERE id=$house_id")->execute();
                Yii::$app->db->createCommand("update house_search set status={$status},online={$online},step_four=1 WHERE house_id={$house_id}")->execute();
                /*if ($old_status == 1) {
                    if ($old_status == 1) {
                        $url1 = JavaUrl . "/api/push/pushsolr";
                        $data1 = array(
                            'houseId' => $house_id
                        );
                        $obj = new Submit();
                        $obj->sub_post($url1, json_encode($data1));
                    }
                }*/
                //@2017-11-7 18:33:09 fuyanfei to add minsu320[添加房源质量权重计算逻辑--并且入库存储]
                $score = Yii::$app->params['house']['house_quality_total_score']; //房源质量中每项的总分数
                $rankBase = Yii::$app->params['house']['house_quality_rank_base'];//房源质量rank值的基数
                $rankRule = Yii::$app->params['house']['house_quality_rank_rule'];//房屋质量rank权重配置
                //图片质量rank值 = (图片得分/总分数5)*房屋质量的总计数250000*图片所占的比重40%
                $house_img_rank = ($house_img/$score)*$rankBase*$rankRule['house_img'];
                //文字描述质量rank值 = (文字描述得分/总分数5)*房屋质量的总计数250000*文字描述所占的比重30%
                $text_description_rank = ($text_description/$score)*$rankBase*$rankRule['text_description'];
                //装修质量rank值 = (装修得分/总分数5)*房屋质量的总计数250000*装修所占的比重10%
                $renovation_rank = ($renovation/$score)*$rankBase*$rankRule['renovation'];
                //床品质量rank值 = (床品得分/总分数5)*房屋质量的总计数250000*床品所占的比重10%
                $bedding_rank = ($bedding/$score)*$rankBase*$rankRule['bedding'];
                //干湿分离（热水）质量rank值 = (干湿分离（热水）得分/总分数5)*房屋质量的总计数250000*干湿分离（热水）所占的比重10%
                $dry_wet_rank = ($dry_wet/$score)*$rankBase*$rankRule['dry_wet'];
                //房屋质量的rank值 = 所有的rank相加
                $quality_rank = $house_img_rank+$text_description_rank+$renovation_rank+$bedding_rank+$dry_wet_rank;
                //@2017-11-8 11:20:58 fuyanfei to add  minsu320[添加前，先删除]
                Yii::$app->db->createCommand("DELETE FROM house_quality_rank_value WHERE  house_id = :house_id")->bindValue(":house_id",$house_id)->execute();
                //重新添加
                Yii::$app->db->createCommand("INSERT INTO house_quality_rank_value(house_id,house_img,text_description,renovation,bedding,dry_wet,house_img_rank,text_description_rank,renovation_rank,bedding_rank,dry_wet_rank,quality_rank) VALUES(:house_id,:house_img,:text_description,:renovation,:bedding,:dry_wet,:house_img_rank,:text_description_rank,:renovation_rank,:bedding_rank,:dry_wet_rank,:quality_rank)")
                    ->bindValue(":house_id",$house_id)
                    ->bindValue(":house_img",$house_img)
                    ->bindValue(":text_description",$text_description)
                    ->bindValue(":renovation",$renovation)
                    ->bindValue(":bedding",$bedding)
                    ->bindValue(":dry_wet",$dry_wet)
                    ->bindValue(":house_img_rank",$house_img_rank)
                    ->bindValue(":text_description_rank",$text_description_rank)
                    ->bindValue(":renovation_rank",$renovation_rank)
                    ->bindValue(":bedding_rank",$bedding_rank)
                    ->bindValue(":dry_wet_rank",$dry_wet_rank)
                    ->bindValue(":quality_rank",$quality_rank)
                    ->execute();
                //----------------------end-minsu320[添加房源质量权重值]----------------------
                $trans->commit();
                $res = 1;
            }
            catch(\Exception $e){
                $trans->rollBack();
                $res = -9;
            }
            if($old_status == 1 && $res == 1){
                $url = JavaUrl . "/api/house/guest/updateHouseScoreByHouseId";
                $data = array(
                    'houseId' => $house_id
                );
                $obj = new Submit();
                $obj->sub_post($url, json_encode($data));
            }
            echo $res;
            die();
        }
        if (!isset($_GET['house_id'])) {
            return $this->render('error');
        }
        $insite_cat = Yii::$app->db->createCommand("select * from dt_house_inside_cat")->queryAll();
        $insite_data = Yii::$app->db->createCommand("select * from dt_house_inside")->queryAll();
        foreach ($insite_cat as $k => $v) {
            foreach ($insite_data as $kk => $vv) {
                if ($v['id'] == $vv['category']) {
                    $insite_cat[$k]['son'][] = $vv;
                }
            }
        }
        $house_id = Yii::$app->request->get('house_id');
        $img = Yii::$app->db->createCommand("select * from house_img_attr WHERE house_id=$house_id")->queryAll();
        $cover_img = Yii::$app->db->createCommand("select cover_img from house_details WHERE id=$house_id")->queryScalar();
        $old_house_data = Yii::$app->db->createCommand("select nearby_intro,traffic_intro,introduce,house_highlights from house_details WHERE id=$house_id")->queryOne();
        $weiyu = Yii::$app->db->createCommand("select * from house_facilities_inside as f JOIN dt_house_inside as d ON f.inside_id=d.id WHERE d.category=3 AND f.house_id=$house_id")->queryAll();
        $sheshi = Yii::$app->db->createCommand("select * from house_facilities_inside as f JOIN dt_house_inside as d ON f.inside_id=d.id WHERE d.category=2 AND f.house_id=$house_id")->queryAll();
        $jiadian = Yii::$app->db->createCommand("select * from house_facilities_inside as f JOIN dt_house_inside as d ON f.inside_id=d.id WHERE d.category=1 AND f.house_id=$house_id")->queryAll();
        $house_error = Yii::$app->db->createCommand("select * from house_audit_log WHERE result=0 AND house_id=$house_id")->queryOne();
        $old_inside = Yii::$app->db->createCommand("select * from house_facilities_inside as h JOIN dt_house_inside as d ON h.inside_id=d.id JOIN dt_house_inside_cat as c ON d.category=c.id WHERE h.house_id=$house_id")->queryAll();
        //@2017-11-7 18:39:13 fuyanfei to add minsu320[查询房源质量权重分数值]
        $qualityInfo = Yii::$app->db->createCommand("SELECT * FROM house_quality_rank_value WHERE house_id = :house_id ORDER BY id DESC LIMIT 1")
            ->bindValue(":house_id",$house_id)
            ->queryOne();
        return $this->render('add-four', [
            'insite_data' => $insite_cat,
            'img' => $img,
            'cover_img' => $cover_img,
            'jiadian' => $jiadian,
            'sheshi' => $sheshi,
            'weiyu' => $weiyu,
            'old_inside' => $old_inside,
            'old_house_data' => $old_house_data,
            'house_error' => $house_error,
            'qualityInfo'=>$qualityInfo,
        ]);
    }

    public function actionDelTitlePic()
    {
        if (Yii::$app->request->isAjax) {
            $house_id = Yii::$app->request->post('house_id');
            echo Yii::$app->db->createCommand("update house_details set cover_img='' WHERE id=$house_id")->execute();
        }
    }

    public function actionGetprovince($id = 0)
    {
        if ($id == '') {
            return '<option value="0">请选择省份</option>';
        }

        $prolist = \Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$id} AND `is_visiable`=1")->queryAll();
        ?>
        <option value="0">请选择省份</option>
        <?php

        foreach ($prolist as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }

    public function actionGetcity($id = 0)
    {

        if ($id == '' || $id == 0) {
            return '<option value="0">请选择城市</option>';
        }

        $prolist = \Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$id} AND `is_visiable`=1")->queryAll();
        ?>
        <option value="0">请选择城市</option>

        <?php

        foreach ($prolist as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }

    public function actionGetarea($id = 0)
    {

        if ($id == '' || $id == 0) {
            return '<option value="0">请选择区域</option>';
        }

        $prolist = \Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$id} AND `is_visiable`=1")->queryAll();
        ?>

        <?php if (!$prolist): ?>
        <option value="0">全境</option>
        <?php
        die;
    endif ?>
        <option value="0">请选择区域</option>

        <?php

        foreach ($prolist as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }


    public static function getData($id)
    {
        $date = CommonService::getDate(date("Y-m-d", time()), date("Y-m-d", time() + 3600 * 24 * 180));

        $tmp = [];
        $price = Yii::$app->db->createCommand("select price from `house_search` WHERE house_id = {$id}")->queryScalar();
        $special_price = Yii::$app->db->createCommand("select * from `house_special_price` WHERE house_id = {$id}")->queryAll();
        $week_price = Yii::$app->db->createCommand("select * from `house_week_price` WHERE house_id = {$id} AND is_delete = 0 ")->queryAll();
        foreach ($date as $k => $v) {
            $tmp[$v] = $price;
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

        return $tmp;


    }
}