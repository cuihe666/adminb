<?php

namespace backend\controllers;
use backend\models\ThematicActivity;
use backend\models\ThematicQrcode;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\models\ThematicActivityQuery;

/**
 * TravelOrderController implements the CRUD actions for TravelOrder model.
 */
class ThematicController extends Controller
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
     * 专题活动列表
     */
    public function actionIndex(){
        $searchModel = new ThematicActivityQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 创建专题活动
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionCreate(){
        $db = ThematicActivity::getDb();
        $model = new ThematicActivity();
        $thematicQrcodeModel = new ThematicQrcode();
        if ($model->load(Yii::$app->request->post())) {
            $beginTransaction = $db->beginTransaction();
            try{
                //分享内容  文本域换行问题
                $model->share_content = str_replace("\n","<br>",Yii::$app->request->post()['ThematicActivity']['share_content']);
                //分享图片
                $model->share_pic = Yii::$app->request->post()['pic'];
                $start_time = strtotime($model->start_time);
                $end_time = strtotime($model->end_time);
                $now_time = time();
                //判断当前时间是否在此活动的开始时间和结束时间之间，如果是的话，活动默认为上线状态，否则为下线状态
                if($now_time<$start_time){
                    $model->status = 3; //如果当前时间小于专题活动开始的时间，则专题活动默认为未开始的状态
                }elseif($now_time>$end_time){
                    $model->status = 4; //如果当前时间大于专题活动结束的时间，则专题活动默认为已到期的状态
                }elseif($now_time >= $start_time && $now_time<=$end_time){
                    $model->status = 1; //如果当前时间大于等于专题活动开始时间并且小于等于专题活动结束时间，则专题活动默认为一上线的状态
                }

                //添加人
                $model->admin_id = Yii::$app->user->identity->getId();
                $model->create_time = date("Y-m-d H:i:s",time());

                if( !$model->save() ){
                    throw new \Exception('thematic_activity_save_error');
                }

                $h5_link = Yii::$app->params['thematicUrl']."?tid=".$model->id;
                Yii::$app->db->createCommand("UPDATE thematic_activity SET h5_link = :h5_link,app_link = :app_link WHERE id=:id")
                    ->bindValue(":h5_link",$h5_link)
                    ->bindValue(":app_link",'') //@update 2017-07-20 pengyang 暂时不写该APP链接的值,因棠果旅居APP已实现UserAgent的标记获取,可通过该标记识别是否是APP访问,且也添加了自定义参数访问
                    ->bindValue(":id",$model->id)
                    ->execute();

                //新添加默认的h5_link二维码数据 @date 2017-07-04 18:04 pengyang
                $thematicQrcodeModel->load([
                    'tid'               => $model->id,
                    'custom_params'     => 'default',//默认的h5_link是没有自定义参数的
                    'qrcode_url'        => $h5_link,//默认的h5_link是没有自定义参数,所以url也不用携带自定义参数了
                    'creator'           => $model->admin_id,
                ],'');
                $thematicQrcodeModel->save();
                if( $thematicQrcodeModel->hasErrors() ){
                    throw new \Exception('thematicQrcode_save_error');
                }

                $beginTransaction->commit();

                Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['thematic-config/index','id'=>$model->id]);

            }catch(\Exception $e){
                $beginTransaction->rollBack();
                $errMap = [
                    'thematic_activity_save_error'  => '专题活动添加失败',
                    'thematicQrcode_save_error'     => '专题活动的二维码数据添加失败',
                ];
                $errInfo = isset($errMap[$e->getMessage()]) ? $errMap[$e->getMessage()] : '数据创建失败';
                Yii::$app->session->setFlash('errors', $errInfo);
            }
        }

        return $this->render('create');
    }

    /**
     * 修改专题活动基本信息
     * @return string|\yii\web\Response
     */
    public function actionUpdate(){
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->render(['index']);
        }
        //查询专题信息
        $model = ThematicActivity::findOne($id);
        $model->share_content = str_replace("<br>","\n", $model->share_content);
        if ($model->load(Yii::$app->request->post())) {
            //分享内容  文本域换行问题
            $model->share_content = str_replace("\n","<br>",Yii::$app->request->post()['ThematicActivity']['share_content']);
            if(isset(Yii::$app->request->post()['pic']) && Yii::$app->request->post()['pic']!=""){
                //分享图片
                $model->share_pic = Yii::$app->request->post()['pic'];
            }
            $start_time = strtotime($model->start_time);
            $end_time = strtotime($model->end_time);
            $now_time = time();

            //判断当前时间是否在此活动的开始时间和结束时间之间，如果是的话，活动默认为上线状态，否则为下线状态
            if($now_time<$start_time)
                $model->status = 3; //如果当前时间小于专题活动开始的时间，则专题活动默认为未开始的状态
            elseif($now_time>$end_time)
                $model->status = 4; //如果当前时间大于专题活动结束的时间，则专题活动默认为已到期的状态
            elseif($now_time >= $start_time && $now_time<=$end_time)
                $model->status = 1; //如果当前时间大于等于专题活动开始时间并且小于等于专题活动结束时间，则专题活动默认为一上线的状态

            $model->update_time = date("Y-m-d H:i:s",time());

            if($model->save()){
                Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['index']);
            }
            else{
                Yii::$app->session->setFlash('errors', '修改失败');
            }
        }
        return $this->render('update',['model'=>$model]);
    }

    /**
     * ajax 上线
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionOnline(){
        $id=Yii::$app->request->post('id');
        if(!isset($id) || $id==0){
            return -1;
        }
        $bo=Yii::$app->db->createCommand("update thematic_activity set status=1,publish_status=1 where id=:id")->bindValue(":id",$id)->execute();
        if($bo){//成功
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * ajax 下线
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionUnline(){
        $id=Yii::$app->request->post('id');
        if(!isset($id) || $id==0){
            return -1;
        }
        $bo=Yii::$app->db->createCommand("update thematic_activity set status=2 where id=:id")->bindValue(":id",$id)->execute();
        if($bo){//成功
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 获取专题活动的基本信息
     * @return int|string
     */
    public function actionGetLink(){
        $id=Yii::$app->request->post('id');
        if(!isset($id) || $id==0){
            return -1;
        }
        $res = Yii::$app->db->createCommand("SELECT name,h5_link,app_link FROM thematic_activity WHERE id = :id")
            ->bindValue(':id',$id)
            ->queryOne();
        return json_encode($res);
    }


}
