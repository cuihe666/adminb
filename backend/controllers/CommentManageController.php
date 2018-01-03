<?php

namespace backend\controllers;

require_once '../../common/tools/yii2-qiniu/autoload.php';
use backend\models\StarLevel;
use backend\models\TravelActivity;
use backend\models\TravelHigo;
use common\tools\Helper;
use Yii;
use backend\models\Comment;
use backend\models\CommentQuery;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Phpexcel;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentManageController extends Controller
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
     * Lists all Comment models.
     * @return mixed
     */
    public function actionTravelIndex()
    {
        $searchModel = new CommentQuery();
        $dataProvider = $searchModel->dosearch(Yii::$app->request->queryParams);

//        Helper::dd($dataProvider->getModels());

        return $this->render('travel-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('travel-view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTravelReview()
    {
        if(Yii::$app->request->isPost){
//            var_dump($_POST);exit;
            $id = Yii::$app->request->post()['Comment']['cid'];
            if(!$id){
//                throw new \Exception('无效点评');
                return $this->redirect(['/comment-manage/travel-index']);
            }
            $trans = Yii::$app->db->beginTransaction();
            try{
                $pic_score = 0;
                $content_score = 0;
                $commentModel = Comment::findOne($id);
                $uid = Yii::$app->user->getId();
                $pics = $_POST['Comment']['pic_arr'];
                if(!empty($pics)){
                    $title_pic = '';
                    $au = Yii::$app->params['qiniu']['access_key'];
                    $sc = Yii::$app->params['qiniu']['secret_key'];
                    $bucket = Yii::$app->params['qiniu']['bucketDef'];
//                    $imgurl = Yii::$app->params['imgUrl'];
                    $auth = new Auth($au, $sc);
                    $token = $auth->uploadToken($bucket);
                    $uploadMgr = new UploadManager();
                    foreach($pics as $k=>$v){
                        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $v, $result)){
                            $houzhui = $result[2];
                            $key = 'comment_sys_' . $uid . '_' .microtime(true) .'.'. $houzhui;
                            // 调用 UploadManager 的 putFile 方法进行文件的上传
                            list($ret, $err) = $uploadMgr->putFile($token, $key, $v);
                            if ($err !== null) {
                                $arr = [
                                    'status' => 0,
                                    'error' => $err
                                ];

                            } else {
                                $arr = [
                                    'status' => 1,
//                                    'imgs' => $imgurl . $ret['key']
                                    'imgs' => $ret['key']
                                ];
//                                $title_pic .= $imgurl . $ret['key']. ',';
                                $title_pic .= $ret['key']. ',';
                            }

                        }else{
                            $title_pic .= $v.',';
                        }
                    }
                    $pic_num = count($pics);
                }

                if($title_pic){
                    $commentModel->pic = $title_pic;
                }
                if($pic_num){
                    if(in_array($pic_num,[1,2,3,4,5])){
                        $pic_score = $pic_num;
                    }elseif($pic_num > 5){
                        $pic_score = 5;
                    }
                }
                $content_num = strlen(Yii::$app->request->post()['Comment']['content']);
                if($content_num && $content_num > 200){
                    $content_score = 2;
                }
                $rank = $pic_score+$content_score+1;
                $total_grade = 0;
                if($commentModel->load(Yii::$app->request->post())){
//                    $total_grade = $commentModel->grade;
                    if($commentModel->obj_type == 3){//旅行类
                        $grade_scheduling = Yii::$app->request->post()['StarLevel']['grade_scheduling'];
                        $grade_guide = Yii::$app->request->post()['StarLevel']['grade_guide'];
                        $grade_leader_service = Yii::$app->request->post()['StarLevel']['grade_leader_service'];
                        $grade_describe = Yii::$app->request->post()['StarLevel']['grade_describe'];
                        $total_grade = Yii::$app->request->post()['StarLevel']['grade'];
//                        $total_grade = ($grade_describe+$grade_leader_service+$grade_guide+$grade_scheduling)/4;
                    }
                    $commentModel->grade = $total_grade;
                    $commentModel->rank = $rank;
                    $commentModel->save();
                    //同步star_level状态 内容 图片 评分 加精
                    $starLevel = StarLevel::find()->where(['c_id' => $id])->one();
//                    var_dump($starLevel);exit;
                    if($starLevel){
                        if($starLevel->type = 3){//旅行
                            $starLevel->grade_scheduling = $grade_scheduling;
                            $starLevel->grade_guide = $grade_guide;
                            $starLevel->grade_leader_service = $grade_leader_service;
                            $starLevel->grade_describe = $grade_describe;
                        }
                        $starLevel->state = $commentModel->state;
                        $starLevel->grade = $total_grade;
                        if(!$starLevel->save()){
//                            var_dump($starLevel->getErrors());exit;
                            $err_logs = json_encode($starLevel->getErrors());
//                            $admin_log = Yii::$app->db->createCommand("INSERT INTO admin_log (admin_id,`table_name`,record_id,remark,create_time) VALUES ($uid,'travel_comment',$id,'审核点评失败。'.$err,now())")
//                                ->execute();
                            throw new \Exception($err_logs);
                        }
                    }
                    $trans->commit();
                    //跳转至下一个待审核产品页面
                    $waitComment = Comment::find()->with('starlevel')->where(['state' => 0,'is_delete' => 0,'obj_type' => 3])->orderBy("create_time asc")->one();
                    if($waitComment){  //跳转至下一个待审核产品页面
                        return $this->redirect(['travel-review', 'comment_id' => $waitComment->id]);
//                        return $this->render('travel-review', [
//                            'model' => $waitComment,
//                        ]);
                    }else{//无需要审核时 跳转当前修改点评查看页
                        return $this->render('travel-view', [
                            'model' => $commentModel,
                        ]);
                    }
                }else{
                    throw new \Exception($commentModel->getErrors());
                }
            }catch(\Exception $e){
                $err = $e->getMessage();
                $trans->rollBack();
//                var_dump($err);exit;
//                throw new \Exception($err);
                // 记录日志
                $admin_log = Yii::$app->db->createCommand("INSERT INTO admin_log (admin_id,`table_name`,record_id,remark,create_time) VALUES ($uid,'travel_comment',$id,'{$err}',now())")
                    ->execute();
                return $this->redirect(['travel-review', 'comment_id' => $id]);
            }


        }else{
            $c_id = Yii::$app->request->get('comment_id');
            $type = '';

            if(!$c_id){
                return $this->redirect(['/comment-manage/travel-index']);
            }

            $model = Comment::find()->with('starlevel')->where(['id' => $c_id])->one();
            if(Yii::$app->request->get('type') ){
                return $this->render('travel-view', [
                    'model' => $model,
                ]);
            }
            return $this->render('travel-review', [
                'model' => $model,
            ]);
        }


    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comment();

        $au = Yii::$app->params['qiniu']['access_key'];
        $sc = Yii::$app->params['qiniu']['secret_key'];
        $auth = new Auth($au,$sc);
        $bucket = Yii::$app->params['qiniu']['bucketDef'];
        $token = $auth->uploadToken($bucket);
        if (Yii::$app->request->isPost) {
            $trans = Yii::$app->db->beginTransaction();
            try{
                $obj_type = 0;
                if(Yii::$app->request->post()['Comment']['obj_sub_type'] && in_array(Yii::$app->request->post()['Comment']['obj_sub_type'],[2,3])){
                    $obj_type = 3;//若二级是旅行方面
                }
                if(!$obj_type){
                    throw new \Exception('非旅行类有效产品');
                }
                //计算rank 1)每条点评基础分为1分 2)字数＞200字的点评+2分 3)每张图片+1分，上限为5分
                $pic = explode(',',Yii::$app->request->post()['Comment']['pic']);
                $pic_num = count($pic);
                $pic_score = 0;
                $content_score = 0;
                if($pic_num){
                    if(in_array($pic_num,[1,2,3,4,5])){
                        $pic_score = $pic_num;
                    }elseif($pic_num > 5){
                        $pic_score = 5;
                    }
                }
                $content_num = strlen(Yii::$app->request->post()['Comment']['content']);
                if($content_num && $content_num > 200){
                    $content_score = 2;
                }
                $rank = $pic_score+$content_score+1;
                //计算rank值结束
//                var_dump(Yii::$app->request->post());exit;
                if($model->load(Yii::$app->request->post())){
                    $model->state = 1;
                    $model->rank = $rank;
                    $model->create_time = date("Y-m-d H:i:s",time());
                    $model->create_by = 1;
                    $model->nickname  = Yii::$app->request->post()['Comment']['nickname'];
                    $model->grade = Yii::$app->request->post()['Comment']['grade'];
                    $model->obj_type = $obj_type;
                    if($model->save()){
                        //同步starlevel数据
                        $star_level = \backend\models\StarLevel::starLevelDo($model);
                        if($star_level === true){
                            $trans->commit();
                            return $this->redirect(['travel-review', 'comment_id' => $model->id,'type' => '2']);

                        }
                    }else{
                        $err = $model->getErrors();
                        $exc = json_encode($err);
                        $trans->rollBack();
                        throw new \Exception($exc);
                    }

                }else{
                    return $this->render('create', [
                        'model' => $model,
                        'token' => $token,
                    ]);
                }

            }catch(\Exception $e){
                $err = $e->getMessage();
                $trans->rollBack();
                throw new \Exception($err);
//                var_dump($err);exit;
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'token' => $token,
            ]);
        }
    }

    /**
     * Deletes an existing Comment model.
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
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /*
     * 批量导入
     * */
    public function actionMutiCreate(){
        $model = new Comment();
        $uid = Yii::$app->user->getId();
//        var_dump(Yii::$app->request->isPost);        exit;

        if(Yii::$app->request->isPost){
            $trans = Yii::$app->db->beginTransaction();
            $imgurl = Yii::$app->params['imgUrl'];
            $au = Yii::$app->params['qiniu']['access_key'];
            $sc = Yii::$app->params['qiniu']['secret_key'];
            $auth = new Auth($au,$sc);
            $bucket = Yii::$app->params['qiniu']['bucketDef'];
            $token = $auth->uploadToken($bucket);
            $qiniu = new UploadManager();
            $key = time().'_'.$uid.'_'.import.".xls";
            try{
                if(!empty($_FILES)){
                    if($_FILES['file']['error'] == 0){
//                        $filepath = $_FILES['file']['tmp_name'];
                        $imgname = mt_rand(1000001,99999999);
                        $error = [];
                        $tmp = $_FILES['file']['tmp_name'];
                        $filepath = Yii::$app->basePath.'/temp-uploads/';//上传至的目录
                        if(move_uploaded_file($tmp,$filepath.$imgname.".xls")){
                            $err = null;
                        }else{
                            $err = '-1';
                        }
//                        list($ret, $err) = $qiniu->putFile($token,$key,$filepath);
                        if($err === null){
//                            $file_path = $imgurl.$ret['key'];
                            $file_path = $filepath.$imgname.'.xls';
                            //phpexcel
                            $phpexcel = new \PHPExcel;
                            $excelReader = \PHPExcel_IOFactory::createReader('Excel5');
                            $phpexcel = $excelReader->load($file_path)->getSheet(0);//载入文件并获取第一个sheet
                            $total_line = $phpexcel->getHighestRow();            //多少行
                            $total_column = $phpexcel->getHighestColumn();       //多少列
                            $info = array();
                            $okk = array();
                            $err = array();
                            for($row = 2; $row <= $total_line; $row++) {
                                $keys = array();
                                for($column = 'A'; $column <= 'F'; $column++) {
                                    if($column=='F') { //M列和O列是时间
                                        $keys[] = Comment::excelTime($phpexcel->getCell($column.$row)->getValue());
                                    }else{
                                        $keys[] = trim($phpexcel->getCell($column.$row)->getValue());
                                    }
                                }


                                //计算rank 1)每条点评基础分为1分 2)字数＞200字的点评+2分 3)每张图片+1分，上限为5分
                                $content_score = 0;
                                $content_num = strlen($keys[4]);
                                if($content_num && $content_num > 200){
                                    $content_score = 2;
                                }
                                $rank = $content_score+1;
                                //计算rank值结束

                                $obj_sub_type = $keys[0];             //产品品类ID
                                $obj_type = (in_array($obj_sub_type,[2,3]))?'3':'';
                                //1.查询导入产品id是否存在 $keys[1]
                                if($obj_type == 2){//活动
                                    $activityModel = TravelActivity::findOne($keys[1]);
                                    if(!$activityModel){
//                                        throw new \Exception('此条活动'.$keys[1].'不存在');
                                        $error[] = '此条活动'.$keys[1].'不存在';
                                        $admin_log = Yii::$app->db->createCommand("INSERT INTO admin_log (admin_id,`table_name`,record_id,remark,create_time) VALUES ($uid,'travel_activity',$keys[1],'批量导入点评失败。此条活动不存在,不可作为有效点评进行批量导入',now())")
                                            ->execute();
                                        continue;
                                    }
                                }elseif($obj_type == 3){//线路
                                    $higoModel = TravelHigo::findOne($keys[1]);
                                    if(!$higoModel){
//                                        throw new \Exception('此条线路'.$keys[1].'不存在');
                                        $error[] = '此条线路'.$keys[1].'不存在';
                                        $admin_log = Yii::$app->db->createCommand("INSERT INTO admin_log (admin_id,`table_name`,record_id,remark,create_time) VALUES ($uid,'travel_theme',$keys[1],'批量导入点评失败。此条线路不存在,不可作为有效点评进行批量导入',now())")
                                            ->execute();
                                        continue;
                                    }
                                }

                                $date = (strtotime($keys[5]))?date("Y-m-d H:i:s",strtotime($keys[5])):date('Y-m-d H:i:s',time());
                                $comModel = new Comment();
                                $comModel->obj_id = $keys[1];
                                $comModel->nickname = $keys[2];
                                $comModel->grade = $keys[3];
                                $comModel->content = $keys[4];
                                $comModel->obj_sub_type = $obj_sub_type;
                                $comModel->obj_type = $obj_type;
                                $comModel->create_time = $date;
                                $comModel->rank = $rank;
                                $comModel->create_by = 1;
                                $comModel->state = 1;
                                $comModel->isNewRecord = true;
                                if(!$comModel->save()){

                                    if(is_array($comModel->getErrors()) && !empty($comModel->getErrors())){
                                        foreach($comModel->getErrors() as $err_keys=>&$err_vals){
                                            foreach($err_vals as $k=>&$err_val){
                                                $err_val = '第'.($row-1).'行'.$err_val;
                                            }
                                        }
                                    }
                                    $errs[]['content'] = $err_vals;
//                                    var_dump($errs);exit;
                                    $error[] = $err_val;
                                    continue;
                                }else{
                                    //2.同步star_level数据
                                    $star_level = \backend\models\StarLevel::starLevelDo($comModel);
                                    if($star_level === true){
                                        $okk[] = $keys[1].'###该导入成功!!!';
                                    }else{
                                        //一条失误记录该失误 然后顺序执行有效数据
                                        $error[] = $star_level;
                                    }
                                }

                            }

                            if($error){
                                $info['err'] = $error;
                            }
                            $info['okk'] = $okk;
                            if($info['err']){
                                $data = array('code'=>'1','info'=>$info['err']);
                                //TODO 加入日志记录
                            }else{
                                $data = array('code'=>'0','info'=>$info['okk']);
                            }
                            $err_str = '';
                            foreach($data['info'] as $kk => $vv){
                                if(is_array($vv)){
                                    foreach($vv as $k=>$v){
                                        if(is_array($v)){
                                            foreach($v as $kkk=>$vvv){
                                                $err_str .= $vvv.',';
                                            }
                                        }else{
                                            $err_str .= $v.',';
                                        }

                                    }
                                }else{
                                    $err_str .= $vv.',';
                                }
                            }
                            Yii::$app->session->setFlash('info',$err_str);

                            Yii::$app->db->createCommand("INSERT INTO admin_log (admin_id,`table_name`,remark,create_time) VALUES ($uid,'comment','.$err_str.',now())")->execute();

                            $trans->commit();
                            unlink($file_path);
                            exec("rm -rf ".$filepath);
                            return  $this->render('muti-create',['model' => $model]);
                            //phpexcel
                        }else{
                            throw new \Exception($err);
                        }

                    }else{
                        throw new \Exception('上传发生错误');
                    }

                }else{
                    throw new \Exception('无有效文件被上传');
                }
            }catch(\Exception $e){
                $trans->rollBack();
                $data = array('code'=>'1','info'=>$e->getMessage());
//                var_dump($e->getMessage());exit;
                $err_arr = '';
                if(is_array($data['info'])){
                    foreach($data['info'] as $kk => $vv){
                        if(is_array($vv)){
                            foreach($vv as $k=>$v){
                                if(is_array($v)){
                                    foreach($v as $kkk=>$vvv){
                                        $err_arr .= $vvv.',';
                                    }
                                }else{
                                    $err_arr .= $v.',';
                                }

                            }
                        }else{
                            $err_arr .= $vv.',';
                        }
                    }
                }else{
                    $err_arr = $e->getMessage();
                }

                Yii::$app->session->setFlash('info',$err_arr);

                return  $this->render('muti-create',['model' => $model]);
            }
        }else{
            return  $this->render('muti-create',['model' => $model]);
        }
    }
    public function actionDownload(){
//            ob_end_clean();
        $path_name = dirname(__FILE__).'/../web/import.xls';
        $r = Yii::$app->response->sendFile($path_name);

    }


}
