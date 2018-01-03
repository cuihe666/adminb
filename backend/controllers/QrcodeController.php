<?php

namespace backend\controllers;
use backend\models\ActiveTheme;
use backend\models\Qrcode;
use backend\models\QrcodeQuery;
use backend\models\TravelHigoQuery;
use backend\models\TravelOrderQuery;
use backend\models\UserQuery;
use backend\service\RegionService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
/**
 * @author:fuyanfei
 * @date:2017年3月25日13:16:10
 * @info:二维码控制器
 * QrcodeController implements the CRUD actions for TravelPerson model.
 */
class QrcodeController extends Controller
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
     * 查询所有的二维码信息列表
     */
    public function actionIndex()
    {
        //实例化QrcodeQuery
        $searchModel=new QrcodeQuery();
        //获取二维码model
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'method'=>'index',
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
        ]);
    }


    /**
     * 新二维码信息
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Qrcode();
        //判断是否为form表单提交过来的数据
        if ($model->load(Yii::$app->request->post())) {
            #获取post提交
            $params = Yii::$app->request->post();
            //dump($params);
            if(isset($params['Qrcode']['city_code3']) && intval($params['Qrcode']['city_code3'])!=0)
                $model->city_code = $params['Qrcode']['city_code3'];
            elseif(isset($params['Qrcode']['city_code2']) && intval($params['Qrcode']['city_code2'])!=0)
                $model->city_code = $params['Qrcode']['city_code2'];
            elseif(isset($params['Qrcode']['city_code1']) && intval($params['Qrcode']['city_code1'])!=0)
                $model->city_code = $params['Qrcode']['city_code1'];
            elseif(isset($params['Qrcode']['city_code']) && intval($params['Qrcode']['city_code'])!=0)
                $model->city_code = $params['Qrcode']['city_code'];
            //获取活动主题类型id，并且根据id获取活动主题的url
            $activeThemeInfo = ActiveTheme::findOne($params['Qrcode']['theme_id']);
            $custom1 = "";
            if(isset($params['Qrcode']['custom1']) && trim($params['Qrcode']['custom1'])!=''){
                $model->custom1 = $params['Qrcode']['custom1'];
                $custom1 = "&c=".$model->custom1;
            }
            //根据活动主题的url和城市编码生成二维码的url
            if(strpos($activeThemeInfo->theme_url, "?")){
                $connect = "&";
            }
            else{
                $connect = "?";
            }
            $model->qrcode_url = $activeThemeInfo->theme_url.$connect."at=".$params['Qrcode']['theme_id']."&cy=".$model->city_code.$custom1;

            $model->create_time = time();    //创建时间
            $model->create_adminid = Yii::$app->user->identity->getId();  //创建人
            $model->text = '';
            if($model->save())
                return $this->redirect(['view', 'id' => $model->qrcode_id]);
        }else{
            //获取国家map
            $country = RegionService::getRegion(0,0);

            return $this->render('create', [
                'model' => $model,
                'country' => $country,
            ]);
        }
    }


    /**
     * 查看二维码信息
     * @param int $id  二维码id
     * @return string
     */
    public function actionView($id)
    {
        #查询二维码信息
        $model = $this->findModelByKey($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * 生成二维码
     * @param $url
     */
    public function actionBuildqrcode($url){
        return \dosamigos\qrcode\QrCode::png($url);    //调用二维码生成方法
    }


    /**
     * 统计二维码下的用户注册量
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUsercount($id,$theme_id){
        //实例化UserQuery
        $searchModel=new UserQuery();
        $searchModel->qrcode_id=Yii::$app->request->queryParams['id'];
        $searchModel->theme_type = Yii::$app->request->queryParams['theme_id'];
        //获取通过此二维码注册的用户数据
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //获取通过此二维码注册的用户数据总量
        $userCount = $searchModel->getCount(Yii::$app->request->queryParams);
        #查询二维码信息
        $model = $this->findModelByKey($id);
        return $this->render('usercount',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'model' => $model,
            'id' => $id,
            'theme_id' => $theme_id,
            'userCount' => $userCount,
        ]);
    }

    /**
     * 统计二维码下的订单
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOrdercount($id,$theme_id){
        //实例化UserQuery
        $searchModel=new TravelOrderQuery();
        $searchModel->qrcode_id=Yii::$app->request->queryParams['id'];
        $searchModel->theme_type = Yii::$app->request->queryParams['theme_id'];
        //获取通过此二维码下单的订单数据
        $dataProvider = $searchModel->searchCount(Yii::$app->request->queryParams,Yii::$app->request->post());
        //Yii::$app->request->post()['TravelOrderQuery']['qrcode_id'] = Yii::$app->request->queryParams[id];
        //dump(Yii::$app->request->post());exit;
        //获取所有的下单量
        $searchModel1 = new TravelOrderQuery();
        $searchModel1->qrcode_id=Yii::$app->request->queryParams['id'];
        $searchModel1->theme_type = Yii::$app->request->queryParams['theme_id'];
        $orderCount = $searchModel1->getOrderCount(Yii::$app->request->queryParams);
        //获取成功下单量
        $searchModel2 = new TravelOrderQuery();
        $searchModel2->qrcode_id=Yii::$app->request->queryParams['id'];
        $searchModel2->theme_type = Yii::$app->request->queryParams['theme_id'];
        $searchModel2->state=999;
        $orderCountSu = $searchModel2->getOrderCount(Yii::$app->request->queryParams);
        //获取首单量
        $searchModel3 = new TravelOrderQuery();
        $searchModel3->qrcode_id=Yii::$app->request->queryParams['id'];
        $searchModel3->theme_type = Yii::$app->request->queryParams['theme_id'];
        $searchModel3->is_firsts = 1;
        $orderCountFirst = $searchModel3->getOrderCount(Yii::$app->request->queryParams);
        #查询二维码信息
        $model = $this->findModelByKey($id);
        return $this->render('ordercount',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'model' => $model,
            'id' => $id,
            'theme_id' => $theme_id,
            'orderCount' => $orderCount,
            'orderCountSu' => $orderCountSu,
            'orderCountFirst' => $orderCountFirst,
        ]);
    }

    /**
     * 统计二维码下的活动点击量
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionHigocount($id){
        if(intval($id)==0){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        //根据id查询当前二维码绑定的活动主题
        $model = $this->findModelByKey($id);
        //根据当前活动主题id查询绑定的所有活动线路
        $activeTheme = ActiveTheme::findOne($model->theme_id);
        if($activeTheme===null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        //获取higoid
        $higo_id_str = $activeTheme->higo_id_str;
        //将字符串转换为数组
        $higoIDArr = explode(",",$higo_id_str);
        //实例化TravelHigoQuery
        $searchModel=new TravelHigoQuery();
        //$searchModel->qrcode_id=Yii::$app->request->queryParams['id'];
        $searchModel->higo_arr = $higoIDArr;
        //获取二维码下的higo活动数据
        $dataProvider = $searchModel->searchForCount(Yii::$app->request->queryParams);
        return $this->render('higocount',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'model' => $model,
            'id' => $id,
        ]);
    }


    /**
     * 根据id查询单条数据
     * @param integer $id
     * @return TravelPerson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByKey($id)
    {
        if (($model = Qrcode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}


