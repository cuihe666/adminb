<?php

namespace backend\controllers;

use backend\models\TgAgent;
use backend\models\TgAgentQuery;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use backend\models\DtCitySeas;
use Yii;

class AgentController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new TgAgentQuery();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }

    public function actionAdd()
    {


        $model = new TgAgent();


        return $this->render('add', ['model' => $model]);
    }

    public static function Getprovince()
    {

        $data = \Yii::$app->redis->get('agent');
        $prolist = unserialize($data);

//        $prolist = \Yii::$app->db->createCommand("select name,code from dt_city_seas where parent=10001")->queryAll();

        $c = [];
        $i = 0;
        $arr1 = [];
        foreach ($prolist as $v) {

            $list['fname'][] = DtCitySeas::getFirstCharter($v['name']);
            $firstword = DtCitySeas::getFirstCharter($v['name']);
            $list['code'][] = $v['code'];
            $list['name'][] = $v['name'];
            if (in_array($firstword, ['A', 'B', 'C', 'D', 'E', 'F', 'G'])) {
                $arr1[$i]['code'] = $v['code'];
                $arr1[$i]['address'] = $v['name'];
            }
            if (in_array($firstword, ['H', 'I', 'J', 'K'])) {
                $arr2[$i]['code'] = $v['code'];
                $arr2[$i]['address'] = $v['name'];
            }
            if (in_array($firstword, ['L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'])) {
                $arr3[$i]['code'] = $v['code'];
                $arr3[$i]['address'] = $v['name'];
            }
            if (in_array($firstword, ['T', 'U', 'V', 'W', 'X', 'Y', 'Z'])) {
                $arr4[$i]['code'] = $v['code'];
                $arr4[$i]['address'][] = $v['name'];
            }
            $i++;
            $code = $v['code'];
            $citylist[$v['code']] = Yii::$app->db->createCommand("select name,code from dt_city_seas where parent='{$code}'")->queryAll();
        }
        $citys = [];
        foreach ($citylist as $k => $v) {
            foreach ($v as $a) {
                //arealist
                $c_p_code = $a['code'];
                $arealist[$c_p_code] = Yii::$app->db->createCommand("select name,code from dt_city_seas where parent='{$c_p_code}'")->queryAll();
                $citys[$k][$a['code']] = $a['name'];
            }
        }
        $area = [];
        foreach ($arealist as $k => $v) {
            foreach ($v as $a) {
                $area[$k][$a['code']] = $a['name'];
            }
        }
//        var_dump($arealist);exit;
        $a = [];
        $a1 = [];
        $a2 = [];
        $a3 = [];
        if ($arr1) {
            foreach ($arr1 as $k => $v) {
                $a[] = $v;
            }
        }
        if ($arr2) {
            foreach ($arr2 as $k => $v) {
                $a1[] = $v;
            }
        }
        if ($arr3) {
            foreach ($arr3 as $k => $v) {
                $a2[] = $v;
            }
        }
        if ($arr4) {
            foreach ($arr4 as $k => $v) {
                $a3[] = $v;
            }
        }
        $c['86'] = [
            "A-G" => $a,
            "H-K" => $a1,
            "L-S" => $a2,
            "T-Z" => $a3,
        ];
        foreach ($citys as $k => $v) {
            $c[$k] = $v;
        }
        foreach ($area as $kk => $vv) {
            $c[$kk] = $vv;
        }
        return json_encode($c);
    }

    public function actionCheckaccount()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $name = $post['name'];
            $name = htmlspecialchars($name);
            $data = Yii::$app->db->createCommand("select username from `tg_agent` WHERE username = '{$name}'")->queryScalar();
            if ($data) {
                echo 1;
            } else {
                echo 0;

            }


        }
    }

    public function actionAjaxadd()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $username = htmlspecialchars($post['username']);
            $password = $post['password'];
            $email = $post['email'];
            $true_name = $post['true_name'];
            $status = $post['status'];
            $area = $post['area'];
            try {
                if (empty($username) || empty($password) || empty($email) || empty($true_name) || empty($status) || empty($area)) {
                    throw new \Exception('非法操作！');
                }

                $data = Yii::$app->db->createCommand("select username from `tg_agent` WHERE username = '{$username}'")->queryScalar();
                if ($data) {
                    throw new \Exception('用户名已存在');
                }

                $data = Yii::$app->db->createCommand("select code  from `tg_agent` WHERE code ={$area}")->queryScalar();
                if ($data) {
                    throw new \Exception('代理商已存在');
                }
                $level = \Yii::$app->db->createCommand("select level from `dt_city_seas` WHERE code = {$area}")->queryScalar();
                if ($level == 1) {
                    $type = 3;
                }
                if ($level == 2) {
                    $type = 1;
                }
                if ($level == 3) {
                    $type = 2;
                }
                $old_invite_code = Yii::$app->db->createCommand("SELECT invite_code FROM `tg_agent` order BY id  DESC ")->queryScalar();
                if ($old_invite_code) {
                    $invite_code = $old_invite_code + 1;
                }


                $password = md5($password);
                $bool = Yii::$app->db->createCommand("INSERT INTO `tg_agent`(username,password,code,status,true_name,email,invite_code,type)VALUES('{$username}','{$password}',{$area},{$status},'{$true_name}','{$email}','{$invite_code}',{$type})")->execute();
                if ($bool) {
                    echo '操作成功';
                }


            } catch (\Exception $e) {
               echo ($e->getMessage());
                die;

            }

        }

    }

    public function actionView()
    {
        try {
            $id = Yii::$app->request->get('id');
            if (!$id) {
                throw new \Exception('非法请求！');
            }
            $data = Yii::$app->db->createCommand("SELECT b.company_name,b.name,b.account_number,b.type,b.company_address,b.tax_num,b.company_email FROM `tg_agent` a LEFT JOIN `agent_bank` b on a.id = b.agent_id WHERE a.id = {$id}")->queryOne();

            $data = ArrayHelper::toArray($data);
        } catch (\Exception $e) {

            echo $e->getMessage();

        }


        return $this->render('view', ['data' => $data]);


    }

    public function actionChangestatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $id = intval($id);
            $oldstatus = Yii::$app->db->createCommand("SELECT status from `tg_agent` WHERE  id = :id")->bindParam(":id", $id)->queryScalar();
            if ($oldstatus == 1) {
                $newstatus = 0;
            }
            if ($oldstatus == 0) {
                $newstatus = 1;
            }

            if (Yii::$app->db->createCommand("UPDATE `tg_agent` set status = :status  WHERE  id = {$id}")->bindParam(":status", $newstatus)->execute()) {
                echo 1;
                die;

            }


        }

    }

}