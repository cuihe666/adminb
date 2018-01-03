<?php

namespace backend\controllers;

use backend\models\UserCommon;
use backend\models\UserInfo;
use backend\service\CommonService;
use Yii;
use backend\models\User;
use backend\models\UserQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        //dump(CommonService::wxtravelruturn('4000712001201706196438945623',1,1,'T1998700376573013'));
        $searchModel = new UserQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTest()
    {
        dump(CommonService::wxtravelreturn1('4000712001201706196438945623',1,1,'T1998700376573013'));
    }

    /**
     * 读取会员详细信息
     * @return string|\yii\web\Response
     */
    public function actionView(){
        $id = Yii::$app->request->get("id") ? Yii::$app->request->get("id") : 0;
        if($id==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        //用户信息
        $info = Yii::$app->db->createCommand(
            "SELECT user.*,info.birthday,info.email,info.number,info.type,info.name,info.number_pic,info.auth,common.nickname FROM user LEFT JOIN user_info as info ON user.id = info.uid LEFT JOIN user_common as common ON user.id = common.uid WHERE user.id = :id"
        )
            ->bindValue(":id",$id)
            ->queryOne();
        //城市区域
        $city = Yii::$app->db->createCommand("select s.name as city,se.name as area from user as u left join dt_city_seas as s on u.citycode = s.code left join dt_city_seas as se on u.areacode = se.code where u.id = :id")->bindValue(":id",$id)->queryOne();
        //操作日志
        $logs = Yii::$app->db->createCommand("SELECT * FROM user_operation_log WHERE uid = :uid")
            ->bindValue(":uid",$id)
            ->queryAll();
        return $this->render('view', [
            'info' => $info,
            'city' => $city,
            'logs' => $logs,
        ]);
    }

    public function actionUpdateStatus(){
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post()['data'];
            $trans = Yii::$app->db->beginTransaction();
            try{
                //修改审核信息
                Yii::$app->db->createCommand("UPDATE user_info SET auth = :auth WHERE uid = :uid")
                    ->bindValue(":auth",$params['status'])
                    ->bindValue(":uid",$params['uid'])
                    ->execute();
                //记录审核记录
                $reasonOther = $params['reasonOther'];
                $reasonStr = "";
                if($params['reasonStr'] != ""){
                    $reasonArr = explode(",",$params['reasonStr']);
                    foreach($reasonArr as $key=>$val){
                        $reasonStr .= Yii::$app->params['house']['house_check_reason'][$val].";";
                    }
                }
                $reasonStr .= $reasonOther;
                Yii::$app->db->createCommand("INSERT INTO user_operation_log(uid,optid,optname,opttime,beforestatus,afterstatus,reason,remark) VALUES (:uid,:optid,:optname,:opttime,:beforestatus,:afterstatus,:reason,:remark)")
                    ->bindValue(":uid",$params['uid'])
                    ->bindValue(":optid",Yii::$app->user->getId())
                    ->bindValue(":optname",Yii::$app->user->identity['username'])
                    ->bindValue(":opttime",date("Y-m-d H:i:s",time()))
                    ->bindValue(":beforestatus",1)
                    ->bindValue(":afterstatus",$params['status'])
                    ->bindValue(":reason",$reasonStr)
                    ->bindValue(":remark",$reasonStr)
                    ->execute();
                $trans->commit();
                $res = [
                    'code' => 0,
                    'msg' => '操作成功'
                ];
            }
            catch(\Exception $e){
                $trans->rollBack();
                $res = [
                    'code' => -2,
                    'msg' => '执行失败'
                ];
            }
        }else{
            $res = [
                'code' => -1,
                'msg' => '请求方式错误！'
            ];
        }
        return json_encode($res);
    }

}
