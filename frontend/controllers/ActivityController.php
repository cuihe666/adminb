<?php
namespace frontend\controllers;

use backend\models\TravelHigo;
use yii\web\Controller;

class ActivityController extends Controller
{
    const ACTIVITY_ID1 = 22222;
    const ACTIVITY_ID2 = 33333;
    const ACTIVITY_ID3 = 44444;
    const COUPON_NO_1 = '595c964c41c4a_170705783';
    const COUPON_NO_2 = '595c96caea500_17070569';
    const COUPON_NO_3 = '595c96fcc807c_170705438';

    public function actionIndex()
    {
        return $this->renderPartial('end');
        if (isset($_GET['uid'])) {
            $uid = \Yii::$app->request->get('uid');
            $coupon_1 = self::COUPON_NO_1;
            $coupon_2 = self::COUPON_NO_2;
            $coupon_3 = self::COUPON_NO_3;
            $coupon_1 = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_1}'")->queryOne();
            if (!$coupon_1) {
                $coupon_1_status = 0;
            } else {
                $coupon_1_status = 1;
            }
            $coupon_2 = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_2}'")->queryOne();
            if (!$coupon_2) {
                $coupon_2_status = 0;
            } else {
                $coupon_2_status = 1;
            }
            $coupon_3 = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_3}'")->queryOne();
            if (!$coupon_3) {
                $coupon_3_status = 0;
            } else {
                $coupon_3_status = 1;
            }
        } else {
            $coupon_1_status = 0;
            $coupon_2_status = 0;
            $coupon_3_status = 0;
        }
        $url = \Yii::$app->urlManager->createAbsoluteUrl('activity/index');
        return $this->renderPartial('index', ['coupon_1_status' => $coupon_1_status, 'coupon_2_status' => $coupon_2_status, 'coupon_3_status' => $coupon_3_status, 'url' => $url]);
    }

    public function actionGetCoupon1()
    {
        return $this->renderPartial('end');
        if (\Yii::$app->request->isAjax) {
            $uid = \Yii::$app->request->post('uid');
            $coupon_1 = self::COUPON_NO_1;
            $activity_1 = self::ACTIVITY_ID1;
            $time = date("Y-m-d", time());
            $old_data = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_1}'")->queryOne();
            if ($old_data) {
                echo -2;
                die;
            }
            $max_num = \Yii::$app->db->createCommand("select daily_max from coupon1_activity WHERE activity_id=$activity_1")->queryScalar();
            if ($max_num > 0) {
                $num = \Yii::$app->db->createCommand("select COUNT(*) from coupon1 WHERE batch_code='{$coupon_1}' AND DATE_FORMAT(create_time,'%Y-%m-%d')='{$time}'")->queryScalar();
                if ($num >= $max_num) {
                    echo -1;
                    die;
                }
            }
            $coupon_batch = \Yii::$app->db->createCommand("select * from coupon1_batch WHERE batch_code='{$coupon_1}'")->queryOne();
            $data = [
                'title' => $coupon_batch['title'],
                'rule' => $coupon_batch['rule'],
                'amount' => $coupon_batch['amount'],
                'is_forever' => $coupon_batch['is_forever'],
                'mode' => $coupon_batch['mode'],
                'type' => $coupon_batch['type'],
                'start_time' => $coupon_batch['start_time'] ? $coupon_batch['start_time'] : date('Y-m-d'),
                'end_time' => $coupon_batch['end_time'] ? $coupon_batch['end_time'] : date('Y-m-d'),
                'update_time' => date('Y-m-d H:i:s', time()),
                'uid' => $uid,
                'batch_code' => $coupon_batch['batch_code'],
                'batch_id' => $coupon_batch['id'],
                'status' => 2,
                'platform' => $coupon_batch['platform'],
                'description' => $coupon_batch['description'],
                'rule_type' => $coupon_batch['rule_type']
            ];
            \Yii::$app->db->createCommand()->insert('coupon1', $data)->execute();
            echo 1;
        }
    }

    public function actionGetCoupon2()
    {
        return $this->renderPartial('end');
        if (\Yii::$app->request->isAjax) {
            $uid = \Yii::$app->request->post('uid');
            $coupon_2 = self::COUPON_NO_2;
            $activity_2 = self::ACTIVITY_ID2;
            $time = date("Y-m-d", time());
            $max_num = \Yii::$app->db->createCommand("select daily_max from coupon1_activity WHERE activity_id=$activity_2")->queryScalar();
            $old_data = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_2}'")->queryOne();
            if ($old_data) {
                echo -2;
                die;
            }
            if ($max_num > 0) {
                $num = \Yii::$app->db->createCommand("select COUNT(*) from coupon1 WHERE batch_code='{$coupon_2}' AND DATE_FORMAT(create_time,'%Y-%m-%d')='{$time}'")->queryScalar();
                if ($num >= $max_num) {
                    echo -1;
                    die;
                }
            }
            $coupon_batch = \Yii::$app->db->createCommand("select * from coupon1_batch WHERE batch_code='{$coupon_2}'")->queryOne();
            $data = [
                'title' => $coupon_batch['title'],
                'rule' => $coupon_batch['rule'],
                'amount' => $coupon_batch['amount'],
                'is_forever' => $coupon_batch['is_forever'],
                'mode' => $coupon_batch['mode'],
                'type' => $coupon_batch['type'],
                'start_time' => $coupon_batch['start_time'] ? $coupon_batch['start_time'] : date('Y-m-d'),
                'end_time' => $coupon_batch['end_time'] ? $coupon_batch['end_time'] : date('Y-m-d'),
                'update_time' => date('Y-m-d H:i:s', time()),
                'uid' => $uid,
                'batch_code' => $coupon_batch['batch_code'],
                'batch_id' => $coupon_batch['id'],
                'status' => 2,
                'platform' => $coupon_batch['platform'],
                'description' => $coupon_batch['description'],
                'rule_type' => $coupon_batch['rule_type']
            ];
            \Yii::$app->db->createCommand()->insert('coupon1', $data)->execute();
            echo 1;
        }
    }

    public function actionGetCoupon3()
    {
        return $this->renderPartial('end');
        if (\Yii::$app->request->isAjax) {
            $uid = \Yii::$app->request->post('uid');
            $coupon_3 = self::COUPON_NO_3;
            $activity_3 = self::ACTIVITY_ID3;
            $time = date("Y-m-d", time());
            $old_data = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_3}'")->queryOne();
            if ($old_data) {
                echo -2;
                die;
            }
            $max_num = \Yii::$app->db->createCommand("select daily_max from coupon1_activity WHERE activity_id=$activity_3")->queryScalar();
            if ($max_num > 0) {
                $num = \Yii::$app->db->createCommand("select COUNT(*) from coupon1 WHERE batch_code='{$coupon_3}' AND DATE_FORMAT(create_time,'%Y-%m-%d')='{$time}'")->queryScalar();
                if ($num >= $max_num) {
                    echo -1;
                    die;
                }
            }
            $coupon_batch = \Yii::$app->db->createCommand("select * from coupon1_batch WHERE batch_code='{$coupon_3}'")->queryOne();
            $data = [
                'title' => $coupon_batch['title'],
                'rule' => $coupon_batch['rule'],
                'amount' => $coupon_batch['amount'],
                'is_forever' => $coupon_batch['is_forever'],
                'mode' => $coupon_batch['mode'],
                'type' => $coupon_batch['type'],
                'start_time' => $coupon_batch['start_time'] ? $coupon_batch['start_time'] : date('Y-m-d'),
                'end_time' => $coupon_batch['end_time'] ? $coupon_batch['end_time'] : date('Y-m-d'),
                'update_time' => date('Y-m-d H:i:s', time()),
                'uid' => $uid,
                'batch_code' => $coupon_batch['batch_code'],
                'batch_id' => $coupon_batch['id'],
                'status' => 2,
                'platform' => $coupon_batch['platform'],
                'description' => $coupon_batch['description'],
                'rule_type' => $coupon_batch['rule_type']
            ];
            \Yii::$app->db->createCommand()->insert('coupon1', $data)->execute();
            echo 1;
        }
    }

    public function actionGame3()
    {
        return $this->renderPartial('end');
        if (isset($_SERVER['HTTP_REFERER'])) {
            $last_url = $_SERVER['HTTP_REFERER'];
            if (isset($_GET['uid']) && $_GET['uid'] > 0) {
                $status = 1;
            } else {
                $status = 0;
            }
        } else {
            $last_url = "http://78hd.tgljweb.com/activity/index?type=h5";
            $status = 2;
        }
        $url = \Yii::$app->urlManager->createAbsoluteUrl('activity/game');
        return $this->renderPartial('game', ['url' => $url, 'status' => $status, 'last_url' => $last_url]);
    }

    public function actionGame()
    {
        return $this->renderPartial('end');
        if (isset($_SERVER['HTTP_REFERER'])) {
            $last_url = $_SERVER['HTTP_REFERER'];
            if (isset($_GET['uid']) && $_GET['uid'] > 0) {
                $status = 1;
            } else {
                $status = 0;
            }
        } else {
            parse_str($_SERVER['QUERY_STRING'], $get);
            if (isset($get['type']) && $get['type'] == 'app') {
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=app";
            } else {
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=h5";
            }
            $status = 2;

        }
        if (isset($_GET['uid'])) {
            $award_list = \Yii::$app->db->createCommand("select * from award_list WHERE uid={$_GET['uid']}")->queryAll();
        } else {
            $award_list = [];
        }
//        print_r($_SERVER);
//        var_dump($last_url);
//        var_dump($status);
        $url = \Yii::$app->urlManager->createAbsoluteUrl('activity/game');
        return $this->renderPartial('game', ['url' => $url, 'status' => $status, 'last_url' => $last_url, 'award_list' => $award_list]);
    }

    function get($str)
    {
        $data = array();
        $parameter = explode('&', end(explode('?', $str)));
        foreach ($parameter as $val) {
            $tmp = explode('=', $val);
            $data[$tmp[0]] = $tmp[1];
        }
        return $data;
    }

    public function actionGetAward()
    {
        return $this->renderPartial('end');
        if (\Yii::$app->request->isAjax) {
            $uid = \Yii::$app->request->post('uid');
            $id = \Yii::$app->request->post('id');
            if ($id == 1) {
                $coupon_batch = \Yii::$app->db->createCommand("select * from coupon1_batch WHERE batch_code='595c981dbc582_170705780'")->queryOne();
                $data = [
                    'title' => $coupon_batch['title'],
                    'rule' => $coupon_batch['rule'],
                    'amount' => $coupon_batch['amount'],
                    'is_forever' => $coupon_batch['is_forever'],
                    'mode' => $coupon_batch['mode'],
                    'type' => $coupon_batch['type'],
                    'start_time' => $coupon_batch['start_time'] ? $coupon_batch['start_time'] : date('Y-m-d'),
                    'end_time' => $coupon_batch['end_time'] ? $coupon_batch['end_time'] : date('Y-m-d'),
                    'update_time' => date('Y-m-d H:i:s', time()),
                    'uid' => $uid,
                    'batch_code' => $coupon_batch['batch_code'],
                    'batch_id' => $coupon_batch['id'],
                    'status' => 2,
                    'platform' => $coupon_batch['platform'],
                    'description' => $coupon_batch['description'],
                    'rule_type' => $coupon_batch['rule_type']
                ];
                $data1 = [
                    'title' => '10元抽奖劵',
                    'uid' => $uid,
                    'create_time' => date('Y-m-d H:i', time()),
                    'type' => $id
                ];
                \Yii::$app->db->createCommand()->insert('award_list', $data1)->execute();
                \Yii::$app->db->createCommand()->insert('coupon1', $data)->execute();
            }
            if ($id == 2) {
                $coupon_batch = \Yii::$app->db->createCommand("select * from coupon1_batch WHERE batch_code='595c98a7858d4_170705575'")->queryOne();
                $data = [
                    'title' => $coupon_batch['title'],
                    'rule' => $coupon_batch['rule'],
                    'amount' => $coupon_batch['amount'],
                    'is_forever' => $coupon_batch['is_forever'],
                    'mode' => $coupon_batch['mode'],
                    'type' => $coupon_batch['type'],
                    'start_time' => $coupon_batch['start_time'] ? $coupon_batch['start_time'] : date('Y-m-d'),
                    'end_time' => $coupon_batch['end_time'] ? $coupon_batch['end_time'] : date('Y-m-d'),
                    'update_time' => date('Y-m-d H:i:s', time()),
                    'uid' => $uid,
                    'batch_code' => $coupon_batch['batch_code'],
                    'batch_id' => $coupon_batch['id'],
                    'status' => 2,
                    'platform' => $coupon_batch['platform'],
                    'description' => $coupon_batch['description'],
                    'rule_type' => $coupon_batch['rule_type']
                ];
                $data1 = [
                    'title' => '60元抽奖劵',
                    'uid' => $uid,
                    'create_time' => date('Y-m-d H:i', time()),
                    'type' => $id
                ];
                \Yii::$app->db->createCommand()->insert('award_list', $data1)->execute();
                \Yii::$app->db->createCommand()->insert('coupon1', $data)->execute();
            }
            if ($id == 3) {
                $data = [
                    'title' => '棠果杯子',
                    'uid' => $uid,
                    'create_time' => date('Y-m-d H:i', time()),
                    'type' => $id
                ];
                \Yii::$app->db->createCommand()->insert('award_list', $data)->execute();
            }
        }
    }

    public function actionCheckAward()
    {
        return $this->renderPartial('end');
        if (\Yii::$app->request->isAjax) {
            $uid = \Yii::$app->request->post('uid');
            $time = date('Y-m-d', time());
            $data = \Yii::$app->db->createCommand("select * from award_list WHERE uid=$uid AND DATE_FORMAT(create_time,'%Y-%m-%d')='{$time}'")->queryOne();
            if ($data) {
                echo 0;
                die;
            } else {
                echo 1;
                die;
            }
        }
    }

    public function actionBaofa()
    {
        return $this->renderPartial('end');
        \Yii::$app->redis->incr('baofa');
        $qianfu_higo_id = [460, 223, 58, 469];
        $qianfu_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $qianfu_higo_id])->all();
        foreach ($qianfu_data as $k => $v) {
            $qianfu_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $qianfu_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $senlin_higo_id = [607, 204, 76, 62];
        $senlin_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $senlin_higo_id])->all();
        foreach ($senlin_data as $k => $v) {
            $senlin_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $senlin_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $lexiang_higo_id = [34, 160, 452, 593];
        $lexiang_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $lexiang_higo_id])->all();
        foreach ($lexiang_data as $k => $v) {
            $lexiang_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $lexiang_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $sichou_higo_id = [59, 351, 355, 476];
        $sichou_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $sichou_higo_id])->all();
        foreach ($sichou_data as $k => $v) {
            $sichou_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $sichou_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $xibu_higo_id = [470, 472, 473, 471];
        $xibu_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $xibu_higo_id])->all();
        foreach ($xibu_data as $k => $v) {
            $xibu_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $xibu_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $ziran_higo_id = [533, 530, 166, 257];
        $ziran_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $ziran_higo_id])->all();
        foreach ($ziran_data as $k => $v) {
            $ziran_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $ziran_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $huwai_higo_id = [466, 467, 359, 406];
        $huwai_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $huwai_higo_id])->all();
        foreach ($huwai_data as $k => $v) {
            $huwai_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $huwai_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $guzhen_higo_id = [361, 363, 407, 387];
        $guzhen_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $guzhen_higo_id])->all();
        foreach ($guzhen_data as $k => $v) {
            $guzhen_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $guzhen_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $huanle_higo_id = [362, 358, 130, 71];
        $huanle_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $huanle_higo_id])->all();
        foreach ($huanle_data as $k => $v) {
            $huanle_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $huanle_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }

        $beijing_id = [1745857, 1750305, 1766873, 1766867];
        $beijing_str = implode(',', $beijing_id);
        $beijing_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($beijing_str)")->queryAll();

        $shenyang_id = [1756608, 1755627, 1757777, 1746382];
        $shenyang_str = implode(',', $shenyang_id);
        $shenyang_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($shenyang_str)")->queryAll();

        $huizhou_id = [1760519, 1759521, 1759433, 1759272];
        $huizhou_str = implode(',', $huizhou_id);
        $huizhou_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($huizhou_str)")->queryAll();

        $shanghai_id = [1626200, 1758389, 1759441, 1615165];
        $shanghai_str = implode(',', $shanghai_id);
        $shanghai_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($shanghai_str)")->queryAll();

        $qingdao_id = [1628594, 1756036, 1741769, 1628078];
        $qingdao_str = implode(',', $qingdao_id);
        $qingdao_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($qingdao_str)")->queryAll();

        $chengdu_id = [1757759, 1758120, 1759359, 1759429];
        $chengdu_str = implode(',', $chengdu_id);
        $chengdu_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($chengdu_str)")->queryAll();

        if (isset($_GET['uid'])) {
            $uid = \Yii::$app->request->get('uid');
            $coupon_1 = self::COUPON_NO_1;
            $coupon_2 = self::COUPON_NO_2;
            $coupon_3 = self::COUPON_NO_3;
            $coupon_1 = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_1}'")->queryOne();
            if (!$coupon_1) {
                $coupon_1_status = 0;
            } else {
                $coupon_1_status = 1;
            }
            $coupon_2 = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_2}'")->queryOne();
            if (!$coupon_2) {
                $coupon_2_status = 0;
            } else {
                $coupon_2_status = 1;
            }
            $coupon_3 = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_code='{$coupon_3}'")->queryOne();
            if (!$coupon_3) {
                $coupon_3_status = 0;
            } else {
                $coupon_3_status = 1;
            }
            $baopin_1 = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_id=413726")->queryOne();
            $baopin_1_count = \Yii::$app->db->createCommand("select count(*) from coupon1 WHERE batch_id=413726")->queryScalar();
            $baopin_1_num = \Yii::$app->db->createCommand("select num from coupon1_batch WHERE id=413726")->queryScalar();
//            $baopin_1_buy = \Yii::$app->db->createCommand("select id from travel_order WHERE `type`=3 AND travel_id=607 AND order_uid=$uid AND trade_no !=''")->queryOne();
            $baopin_1_buy = \Yii::$app->db->createCommand("select id from order_state WHERE `pay_stauts`=2 AND house_id=1766873 AND order_uid=$uid")->queryOne();
            $baopin_2 = \Yii::$app->db->createCommand("select id from coupon1 WHERE uid=$uid AND batch_id=413727")->queryOne();
            $baopin_2_count = \Yii::$app->db->createCommand("select count(*) from coupon1 WHERE batch_id=413727")->queryScalar();
            $baopin_2_num = \Yii::$app->db->createCommand("select num from coupon1_batch WHERE id=413727")->queryScalar();
            $baopin_2_buy = \Yii::$app->db->createCommand("select id from order_state WHERE `pay_stauts`=2 AND house_id=1767243 AND order_uid=$uid")->queryOne();
            $baopin1_status = 2; //未领
            $baopin2_status = 2; //未领
            if ($baopin_1_count >= $baopin_1_num) {
                $baopin1_status = 0; //售完
            }
            if ($baopin_1) {
                $baopin1_status = 1; //已领
            }
            if ($baopin_1_buy) {
                $baopin1_status = 3; //已购
            }
            if ($baopin_2_count >= $baopin_2_num) {
                $baopin2_status = 0; //售完
            }
            if ($baopin_2) {
                $baopin2_status = 1; //已领
            }
            if ($baopin_2_buy) {
                $baopin2_status = 3; //已购
            }
        } else {
            $baopin_1_count = \Yii::$app->db->createCommand("select count(*) from coupon1 WHERE batch_id=413726")->queryScalar();
            $baopin_1_num = \Yii::$app->db->createCommand("select num from coupon1_batch WHERE id=413726")->queryScalar();
            $baopin_2_count = \Yii::$app->db->createCommand("select count(*) from coupon1 WHERE batch_id=413727")->queryScalar();
            $baopin_2_num = \Yii::$app->db->createCommand("select num from coupon1_batch WHERE id=413727")->queryScalar();
            $baopin1_status = 2; //未领
            $baopin2_status = 2; //未领
            if ($baopin_1_count >= $baopin_1_num) {
                $baopin1_status = 0; //售完
            }
            if ($baopin_2_count >= $baopin_2_num) {
                $baopin2_status = 0; //售完
            }
            $coupon_1_status = 0;
            $coupon_2_status = 0;
            $coupon_3_status = 0;
        }
        $url = \Yii::$app->urlManager->createAbsoluteUrl('activity/baofa');
        return $this->renderPartial('baofa', ['baopin1_status' => $baopin1_status, 'baopin2_status' => $baopin2_status, 'url' => $url, 'coupon_1_status' => $coupon_1_status, 'coupon_2_status' => $coupon_2_status, 'coupon_3_status' => $coupon_3_status,
            'qianfu_data' => $qianfu_data,
            'senlin_data' => $senlin_data,
            'lexiang_data' => $lexiang_data,
            'sichou_data' => $sichou_data,
            'xibu_data' => $xibu_data,
            'ziran_data' => $ziran_data,
            'huwai_data' => $huwai_data,
            'guzhen_data' => $guzhen_data,
            'huanle_data' => $huanle_data,
            'beijing' => $beijing_data,
            'shenyang' => $shenyang_data,
            'huizhou' => $huizhou_data,
            'shanghai' => $shanghai_data,
            'qingdao' => $qingdao_data,
            'chengdu' => $chengdu_data
        ]);
    }

    public function actionGetdeg()
    {
        return $this->renderPartial('end');
        if (\Yii::$app->request->isAjax) {
            $time = date('Y-m-d', time());
            $cup_num = \Yii::$app->db->createCommand("select count(*) from award_list WHERE type=3 AND DATE_FORMAT(create_time,'%Y-%m-%d')='{$time}'")->queryScalar();
            $coupon_60 = \Yii::$app->db->createCommand("select count(*) from award_list WHERE type=2 AND DATE_FORMAT(create_time,'%Y-%m-%d')='{$time}'")->queryScalar();
            $arr = [[30, 90], [30, 90], [150, 210], [270, 330], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210]];
            if ($coupon_60 >= 3 && $cup_num <= 20) {
                $arr = [[30, 90], [30, 90], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210]];
            }
            if ($cup_num >= 20 && $coupon_60 <= 30) {
                $arr = [[30, 90], [30, 90], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210]];
            }
            if ($cup_num >= 20 && $coupon_60 >= 30) {
                $arr = [[150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210], [150, 210]];
            }
            $suiji = $this->randomFloat();
            $arr_num = count($arr);
            echo json_encode(rand($arr[floor($suiji * $arr_num)][0], $arr[floor($suiji * $arr_num)][1]));
        }
    }

    function randomFloat($min = 0, $max = 1)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }

    public function actionMinsu()
    {
        return $this->renderPartial('end');
        \Yii::$app->redis->incr('minsu');
        if (isset($_SERVER['HTTP_REFERER'])) {
            $last_url = $_SERVER['HTTP_REFERER'];
            if (isset($_GET['uid']) && $_GET['uid'] > 0) {
                $status = 1;
            } else {
                $status = 0;
            }
        } else {
            parse_str($_SERVER['QUERY_STRING'], $get);
            if (isset($get['type']) && $get['type'] == 'app') {
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=app";
            } else {
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=h5";
            }
            $status = 2;
        }
        $beijing_id = [1751669, 1762934, 1753321, 1753335.1753522, 1753540, 1751662, 1766763, 1753295, 1762388, 1750275, 1753292, 1751648];
        $beijing_str = implode(',', $beijing_id);
        $beijing_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($beijing_str)")->queryAll();

        $chengdu_id = [1757759, 1758120, 1759359, 1758425.1759429, 1757897, 1757899, 1757908, 1757956, 1757958, 1757963, 1757965, 1757967];
        $chengdu_str = implode(',', $chengdu_id);
        $chengdu_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($chengdu_str)")->queryAll();

        $shenyang_id = [1620480, 1613061, 1753120, 1613528.1643903, 1760080, 1656771, 1620485, 1637026, 1612806, 1619371, 1628075, 1745708];
        $shenyang_str = implode(',', $shenyang_id);
        $shenyang_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($shenyang_str)")->queryAll();
        $url = \Yii::$app->urlManager->createAbsoluteUrl('activity/minsu');
        return $this->renderPartial('minsu', ['status' => $status, 'url' => $url, 'last_url' => $last_url, 'beijing' => $beijing_data, 'chengdu' => $chengdu_data, 'shenyang' => $shenyang_data]);
    }

    public function actionLvxing()
    {
        return $this->renderPartial('end');
        \Yii::$app->redis->incr('lvxing');
        if (isset($_SERVER['HTTP_REFERER'])) {
            $last_url = $_SERVER['HTTP_REFERER'];
            if (isset($_GET['uid']) && $_GET['uid'] > 0) {
                $status = 1;
            } else {
                $status = 0;
            }
        } else {
            parse_str($_SERVER['QUERY_STRING'], $get);
            if (isset($get['type']) && $get['type'] == 'app') {
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=app";
            } else {
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=h5";
            }
            $status = 2;
        }
        $higo_id = [675, 671, 645, 640, 639, 638, 623, 624, 627, 628, 629, 630, 633, 634, 635, 636, 637, 616, 617, 619];
        $higo_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $higo_id])->all();
        foreach ($higo_data as $k => $v) {
            $higo_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $higo_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $url = \Yii::$app->urlManager->createAbsoluteUrl('activity/lvxing');
        return $this->renderPartial('lvxing', ['status' => $status, 'last_url' => $last_url, 'url' => $url, 'higo' => $higo_data]);
    }

    public function actionHotel()
    {
        return $this->renderPartial('end');
        \Yii::$app->redis->incr('jiudian');
        if (isset($_SERVER['HTTP_REFERER'])) {
            $last_url = $_SERVER['HTTP_REFERER'];
            if (isset($_GET['uid']) && $_GET['uid'] > 0) {
                $status = 1;
            } else {
                $status = 0;
            }
        } else {
            parse_str($_SERVER['QUERY_STRING'], $get);
            if (isset($get['type']) && $get['type'] == 'app') {
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=app";
            } else {
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=h5";
            }
            $status = 2;
        }
        $hotel_id = [1767254, 1767243, 1767210, 1767212, 1767216, 1763435, 1767257, 1767251, 1767247, 1763829, 1767265, 1767260, 1767250, 1767249];
        $hotel_str = implode(',', $hotel_id);
        $hotel_data = \Yii::$app->db->createCommand("select d.title,d.cover_img,d.id,s.price from house_details as d JOIN house_search as s ON d.id=s.house_id WHERE d.id IN ($hotel_str)")->queryAll();
        $url = \Yii::$app->urlManager->createAbsoluteUrl('activity/hotel');
        return $this->renderPartial('hotel', ['status' => $status, 'last_url' => $last_url, 'url' => $url, 'hotel' => $hotel_data]);
    }

    public function actionHaiwai()
    {
        return $this->renderPartial('end');
        \Yii::$app->redis->incr('haiwai');
        if (isset($_SERVER['HTTP_REFERER'])) {
            $last_url = $_SERVER['HTTP_REFERER'];
            if (isset($_GET['uid']) && $_GET['uid'] > 0) {
                $status = 1;
            } else {
                $status = 0;
            }
        } else {
            parse_str($_SERVER['QUERY_STRING'], $get);
            if (isset($get['type']) && $get['type'] == 'app') {
//                $last_url = "http://106.14.239.108:9999/activity/baofa?type=app";
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=app";
            } else {
//                $last_url = "http://106.14.239.108:9999/activity/baofa?type=h5";
                $last_url = "http://78hd.tgljweb.com/activity/baofa?type=h5";
            }
            $status = 2;
        }
        $higo_id = [674, 650, 620, 607, 597, 592, 593, 571, 564, 525, 520, 521, 522, 500, 493, 488, 474, 469, 460, 453];
        $higo_data = TravelHigo::find()->asArray()->select(['title_pic', 'first_pic', 'id', 'name'])->where(['id' => $higo_id])->all();
        foreach ($higo_data as $k => $v) {
            $higo_data[$k]['price'] = \Yii::$app->db->createCommand("select adult_price from travel_higo_date_price WHERE higo_id={$v['id']} AND status=1")->queryScalar();
            $higo_data[$k]['title_pic'] = explode(',', $v['title_pic']);
        }
        $url = \Yii::$app->urlManager->createAbsoluteUrl('activity/haiwai');
        return $this->renderPartial('haiwai', ['status' => $status, 'last_url' => $last_url, 'url' => $url, 'higo' => $higo_data]);
    }

    public function actionGetSpecial()
    {
        return $this->renderPartial('end');
        if (\Yii::$app->request->isAjax) {
            $uid = \Yii::$app->request->post('uid');
            $batch_id = \Yii::$app->request->post('batch_id');
            $time = date("Y-m-d", time());
            $coupon_batch = \Yii::$app->db->createCommand("select * from coupon1_batch WHERE id={$batch_id}")->queryOne();
            $data = [
                'title' => $coupon_batch['title'],
                'rule' => $coupon_batch['rule'],
                'amount' => $coupon_batch['amount'],
                'is_forever' => $coupon_batch['is_forever'],
                'mode' => $coupon_batch['mode'],
                'type' => $coupon_batch['type'],
                'start_time' => $coupon_batch['start_time'] ? $coupon_batch['start_time'] : date('Y-m-d'),
                'end_time' => $coupon_batch['end_time'] ? $coupon_batch['end_time'] : date('Y-m-d'),
                'update_time' => date('Y-m-d H:i:s', time()),
                'uid' => $uid,
                'batch_code' => $coupon_batch['batch_code'],
                'batch_id' => $coupon_batch['id'],
                'status' => 2,
                'platform' => $coupon_batch['platform'],
                'description' => $coupon_batch['description'],
                'rule_type' => $coupon_batch['rule_type']
            ];
            \Yii::$app->db->createCommand()->insert('coupon1', $data)->execute();
            echo 1;
        }
    }

    public function actionEnd()
    {
        return $this->renderPartial('end');
    }

}