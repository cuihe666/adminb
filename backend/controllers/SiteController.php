<?php
namespace backend\controllers;

use backend\config\Consts;
use backend\models\UserBackend;
use backend\service\CommonService;
use Yii;
use yii\log\Logger;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\Error Action',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        // 判断用户是访客还是认证用户
        // isGuest为真表示访客，isGuest非真表示认证用户，认证过的用户表示已经登录了，这里跳转到主页面
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // 实例化登录模型 common\models\LoginForm
        $model = new LoginForm();

        // 接收表单数据并调用LoginForm的login方法
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } // 非post直接渲染登录表单
        else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionTest()
    {
       dump(CommonService::alipayQuery('2017063021001004300216619933'));
    }

    public function curl($url, $data, $header = false, $method = "POST")
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $ret = curl_exec($ch);
        return $ret;
    }


//    修改密码
    public function actionChangepass()
    {
        $uid = Yii::$app->user->id;
        $model = UserBackend::findOne($uid);
        $model->setScenario('changepass');
        $model->password_hash = '';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->new_password);
            $model->save(false);
            Yii::$app->user->logout();
            return $this->goHome();

        }
        return $this->render('changepass', ['model' => $model]);
    }

}
