<?php
namespace frontend\controllers;

use backend\models\Submit;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionLogin()
    {
        $session = \Yii::$app->session;
        return $this->renderPartial('login');
    }

    //发送验证码
    public function actionSend_verify()
    {
        if (\Yii::$app->request->isAjax) {
            $url = JavaUrl . ":9090/api/push/sendverifyuser";
            $info = \Yii::$app->request->post('data');
            $data = array(
                'areaCode' => $info['areaCode'],
                'mobile' => $info['mobile'],
                'sendMode' => $info['sendMode'],
                'sign' => $info['sign'],
            );
            $obj = new Submit();
            $order_info = $obj->sub_post($url, json_encode($data));
            $datastr = [];
            $datastr['code'] = $order_info['code'];
            $datastr['mes'] = $order_info['msg'];
            return json_encode($datastr);
        }
    }

    //验证码登录
    public function actionLogin_fast()
    {
        if (\Yii::$app->request->isAjax) {
            $url = JavaUrl . ":9090/api/user/loginbyshortcut";
            $info = \Yii::$app->request->post('data');
            $data = array(
                'mobile' => $info['account'],
                'identifyCode' => $info['verify'],
                'source' => $info['source'],
            );
            $obj = new Submit();
            $order_info = $obj->sub_post($url, json_encode($data));
            $datastr = [];
            $datastr['code'] = $order_info['code'];
            $datastr['mes'] = $order_info['msg'];
            $datastr['data'] = $order_info['data'];
            if ($order_info['code'] == 0) {
                $session = \Yii::$app->session;
                session_set_cookie_params(24 * 3600);
                $session['user'] = [
                    'nickname' => $order_info['data']['nickname'],
                    'uid' => $order_info['data']['uid'],
                ];
            }
            echo json_encode($datastr);
        }
    }

    public function actionTest()
    {
       echo \Yii::$app->redis->get('baofa');
    }
}