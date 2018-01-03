<?php

namespace backend\controllers;

use Yii;
use backend\models\TravelHigo;
use backend\models\TravelHigoQuery;
use backend\models\TravelActivity;
use backend\models\TravelActivityQuery;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\TravelTag;
use backend\models\TravelTagQuery;
use backend\models\TravelTagNote;
use backend\models\TravelTagNoteQuery;
use backend\models\TravelGuideQuery;

/**
 * TravelHigoController implements the CRUD actions for TravelHigo model.
 */
class TravelTagManageController extends Controller
{
    public function actionHigo()
    {
        $searchModel = new TravelTagQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,3);
        //var_dump($dataProvider);exit;
        return $this->render('higo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHigoStore(){
        $model = new TravelTag();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if($data['title'] && $data['type'] && isset($data['status']) && $data['store_type']){
                if($data['store_type'] == 1){
                    Yii::$app->db->createCommand("insert into  travel_tag(`title`,`desc`,`sort`,`status`,`type`) VALUES ('{$data['title']}','{$data['desc']}','{$data['sort']}','{$data['status']}','{$data['type']}')")->execute();
                }else if($data['store_type'] == 2){
                    if($data['id']){
                        Yii::$app->db->createCommand("UPDATE  `travel_tag` SET `status` = '{$data['status']}',`title`='{$data['title']}',`desc`='{$data['desc']}',`sort` = '{$data['sort']}'  WHERE  id ={$data['id']} ")->execute();
                    }
                }
                return 1;
            }else{
                return -1;
            }
        }
    }

    public function actionActivity()
    {
        $searchModel = new TravelTagQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,2);

        return $this->render('activity', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHigoLine(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if($data['id'] && isset($data['type'])){
                Yii::$app->db->createCommand("UPDATE  `travel_tag` SET status = {$data['type']}  WHERE  id ={$data['id']} ")->execute();
                if($data['type'] == '0'){//禁用
                    if(!$data['model']){
                        return -1;
                    }
                    $field = 'tag';
                    $table_name = '';
                    switch ($data['model']){
                        case 2:
                            $table_name = 'travel_activity';
                            break;
                        case 3:
                            $table_name = 'travel_higo';
                            break;
                        case 4:
                            $table_name = 'travel_guide';
                            break;
                        case 5:
                            $table_name = 'travel_impress';
                            $field = 'type';
                            break;
                        default:
                            $table_mame = '';
                            break;
                    }
                    if($table_name){
//                    if($data['items'] != 0){
                        $oldid = $data['id'];
                        $newid = $data['items'];
                        $olddata = Yii::$app->db->createCommand("SELECT id,$field from  `".$table_name."` WHERE  FIND_IN_SET($oldid,$field) ")->queryAll();
                        if($olddata){
                            foreach($olddata as $k=>$v){
                                $tag = explode(',',$v['tag']);
                                if(!empty($tag)){
                                    foreach($tag as $aa =>$bb){
                                        if($bb == $oldid){
                                            unset($tag[$aa]);
                                        }
                                    }
                                    if($newid){
                                        if(!in_array($newid,$tag)){
                                            array_push($tag,$newid);
                                        }
                                    }
                                }
                                if(is_array($tag)){
                                    sort($tag);
                                }
                                $tag = implode(',',$tag);
                                $sql = Yii::$app->db->createCommand("UPDATE  `".$table_name."` SET tag = '{$tag}'  WHERE  id ={$v['id']} ")->execute();
                            }
                        }
//                    }//做所有含$data['id'] 这个id的标签全部替换为 $data['change_item']
                    }
                }
                return 1;
            }else{
                return -1;
            }
        }
    }

    public function actionImpress(){
        $searchModel = new TravelTagQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,5);

        return $this->render('impress', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionNote(){
        $searchModel = new TravelTagNoteQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,6);
        $options = TravelTag::find()->where(['type'=>6,'status' => 1])->all();
//        var_dump($options);exit;
        return $this->render('note', [
            'options' => $options,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNoteStore(){
        $model = new TravelTagNote();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if($data['title'] && isset($data['status']) && $data['store_type'] && $data['tag']){
                if($data['store_type'] == 1){
                    Yii::$app->db->createCommand("insert into  travel_tag_note(`title`,`desc`,`sort`,`status`,`travel_tag_id`) VALUES ('{$data['title']}','{$data['desc']}','{$data['sort']}','{$data['status']}','{$data['tag']}')")->execute();
                }else if($data['store_type'] == 2){
                    if($data['id']){
                        Yii::$app->db->createCommand("UPDATE  `travel_tag_note` SET `travel_tag_id` = '{$data['tag']}',`status` = '{$data['status']}',`title`='{$data['title']}',`desc`='{$data['desc']}',`sort` = '{$data['sort']}'  WHERE  id ={$data['id']} ")->execute();
                    }
                }
                return 1;
            }else{
                return -1;
            }
        }
    }


    public function actionNoteLine(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $trans = Yii::$app->db->beginTransaction();

            try{
                Yii::$app->db->createCommand("UPDATE  `travel_tag_note` SET status = {$data['type']}  WHERE  id ={$data['id']} ")->execute();

                if($data['id'] && isset($data['type'])){
                    //if($data['change_item'] == 0){//不做修改的标签禁用
                    //}//else 做所有含$data['id'] 这个id的标签全部替换为 $data['change_item']
                    if($data['model'] && isset($data['change_item'])){
                        $field = $data['model'];
                        $oldid = $data['id'];
                        $sql = Yii::$app->db->createCommand("SELECT id FROM  `travel_note` WHERE $field = {$oldid}")->queryAll();
//                        if($data['change_item'] != 0){
                            $newid = $data['change_item'];
                            if(is_array($sql) && !empty($sql)){
                                foreach($sql as $k => $v){
                                    Yii::$app->db->createCommand("UPDATE  `travel_note` SET $field = {$data['change_item']}  WHERE  id ={$v['id']} ")->execute();
                                }
                            }
//                        }
                    }
                    $trans->commit();
                    return 1;
                }else{
                    $trans->rollBack();
                    return -1;
                }
            }catch(Exception $e){
                $errors = $e->getMessage();
                //todo log
            }

        }
    }

    public function actionNoteGetchange(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $field = '';
            if($data['id'] && isset($data['p_id'])){
                $arr = [];
                $result = Yii::$app->db->createCommand("SELECT * FROM  `travel_tag_note` WHERE travel_tag_id = {$data['p_id']} AND  id !={$data['id']}  AND status=1")->queryAll();
                $str = '<option value="0">不做替换</option>';
                if($result){
                    foreach($result as $k=>$v){
                        $id = $v['id'];
                        $str.="<option value='$id'>".$v['title']."</option>";
                    }
                }
                $field_data = Yii::$app->db->createCommand("SELECT travel_tag.desc FROM travel_tag WHERE id={$data['p_id']}")->queryOne();
                $field = $field_data['desc'];
                if($field){
                    //查询使用该标签的游记数量
                    $nums = Yii::$app->db->createCommand("SELECT count(*) as num FROM travel_note WHERE $field={$data['id']}")->queryOne();

                    $arr['status'] = 1;
                    $arr['field'] = $field;
                    $arr['nums'] = $nums['num'];//使用该标签的游记数量
                    $arr['options'] = $str;
                }

            }else{
                $arr['status'] = -1;
            }
            return json_encode($arr);
        }
    }

    public function actionGetChanges(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            if($data['id'] && isset($data['mode'])){
                $arr = [];
                $result = Yii::$app->db->createCommand("SELECT * from  `travel_tag` WHERE type = {$data['mode']} AND  id !={$data['id']} AND status=1")->queryAll();
                $str = '<option value="0">不做替换</option>';
                if($result){
                    foreach($result as $k=>$v){
                        $id = $v['id'];
                        $str.="<option value='$id'>".$v['title']."</option>";
                    }
                }

                //查询使用该标签的游记数量
                $nums = 0;
                if($data['mode'] == 2){ //当地活动
                    $nums = Yii::$app->db->createCommand("SELECT count(*) as num FROM travel_activity WHERE FIND_IN_SET({$data['id']},tag)")->queryOne();
                }
                if($data['mode'] == 3){ //higo
                    $nums = Yii::$app->db->createCommand("SELECT count(*) as num FROM travel_higo WHERE FIND_IN_SET({$data['id']},tag)")->queryOne();
                }
                if($data['mode'] == 4){
                    $nums = Yii::$app->db->createCommand("SELECT count(*) as num FROM travel_guide WHERE FIND_IN_SET({$data['id']},tag)")->queryOne();
                }
                if($data['mode'] == 5){
                    $nums = Yii::$app->db->createCommand("SELECT count(*) as num FROM travel_impress WHERE FIND_IN_SET({$data['id']},type)")->queryOne();
                }
                if($data['mode'] == 6){
//                    $nums = Yii::$app->db->createCommand("SELECT count(*) as num FROM travel_note WHERE FIND_IN_SET({$data['id']},tag)")->queryOne();
                    $nums['num'] = 0;
                }
//                var_dump($nums['num']);exit;
                $arr['status'] = 1;
                $arr['nums'] = $nums['num'];
                $arr['options'] = $str;
            }else{
                $arr['status'] = -1;
            }

            return json_encode($arr);
        }
    }

    public function actionGuide(){
        $searchModel = new TravelTagQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,4);

        $options = TravelTag::find()->where(['type'=>4,'status' => 1])->all();
        return $this->render('guide', [
            'options' => $options,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
