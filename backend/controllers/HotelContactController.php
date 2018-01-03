<?php

namespace backend\controllers;


use backend\models\HotelContact;
use backend\traits\AjaxTrait;
use common\tools\Helper;
use Yii;

class HotelContactController extends \yii\web\Controller
{
    use AjaxTrait;
    public $enableCsrfValidation = false;
    public $theme;
    public $theme_id;


    public function init()
    {
        parent::init();

        $this->theme = Yii::$app->request->get('theme',0);
        $this->theme_id = Yii::$app->request->get('theme_id',0);

    }

    /**
     * 获取联系人列表
     */
    public function actionList()
    {
        $list = $this->getList();

        if(empty($list)){
            $list = $this->getTempList();
        }

        $list = array_map(function($item){
            $item['status'] = 'show';
            return $item;
        },$list);
        return $this->apiResponse($list);
    }

    /**
     * 存储联系人
     * @return array
     */
    public function actionStore(){
        $data =  Helper::requestPayload();
        $request = $data['body'];

        if($this->checkCommit($request)){
            return $this->apiResponse([
                'code' => 403,
                'message' => '请填写联系人的相关信息'
            ]);
        }


        $request['theme_id'] = $this->getThemeId();
        $request['theme'] = $this->getTheme();

        //如果是未保存的内容
        if (!$request['theme_id']){
            return $this->storeTempList($data);
        }

        $model = $this->getModel($request['id']);
        Helper::loadModel($model,$request);

        if ($model->save()){
            return $this->apiResponse([
                'code' => 200,
                'message' => 'success'
            ]);
        }else{
            $msg = current(current($model->getErrors()));
            if($msg == '供应商or酒店id不能为空。'){
                $msg = '请先保存当前供应商信息再添加联系人';
            }


            return $this->apiResponse([
                'code' => 403,
                'message' => $msg
            ]);
        }
    }

    //检测提交的数据不能为空
    protected function checkCommit($request){
        unset($request['id']);
        unset($request['status']);
        $res = true;
        foreach ($request as $item){
            if(!empty($item)){
                $res = false;
            }
        }

        return $res;
    }

    /**
     * 删除联系人
     * @return array
     */
    public function actionDel(){
        $request = Helper::requestPayload();

        if(!isset($request['id'])){
            return $this->delTempList($request);
        }

        $model = $this->getModel($request['id']);

        if(!isset($request['id']) || is_null($model)){
            return $this->apiResponse([
                'code' => 401,
                'message' => '需要提供删除的 id'
            ]);
        }

        if($model->delete()){
            return $this->apiResponse([
                'code' => 200,
            ]);
        }else{
            return $this->apiResponse([
                'code' => 400,
                'message' => '删除错误'
            ]);
        }
    }

    /**
     * 从数据库中获取内容
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getList(){
        $model = HotelContact::find()
            ->select(['id','type','name','job','mobile','email','landline'])
            ->where([
                'theme' => $this->theme,
                'theme_id' => $this->theme_id
            ])
            ->asArray()->all();

        return $model;
    }

    /**
     * 获取临时缓存的联系人列表,没存到库中,目前由 session 驱动
     * @return mixed
     */
    public function getTempList(){
        return Yii::$app->session->get('temp_contact_list',[]);
    }

    //添加联系人
    public function storeTempList($data){
        $request = $data['body'];
        unset($request['id']);
        $request['theme_id'] = 9999;

        //模型验证
        $model = new HotelContact();
        Helper::loadModel($model,$request);
        if(!$model->validate()){
            $msg = current(current($model->getErrors()));
            return $this->apiResponse([
                'code' => 403,
                'message' => $msg
            ]);
        }

        //验证完毕后如果是编辑
        if($request['status'] == 'edit'){
            return $this->editTempList($data);
        }


        $temp_list = Yii::$app->session->get('temp_contact_list',[]);
        array_push($temp_list,$request);
        Yii::$app->session->set('temp_contact_list',$temp_list);

        return $this->apiResponse([
            'code' => 200
        ]);
    }

    public function editTempList($data){
        $request = $data['body'];
        $index  =  $data['index'];
        $list = $this->getTempList();
        $request['status'] = 'add';

        $list[$index] = $request;

        Yii::$app->session->set('temp_contact_list',$list);
        return $this->apiResponse([
            'code' => 200
        ]);
    }

    //删除联系人
    public function delTempList($request){
        $index = $request['index'];
        $temp_list = Yii::$app->session->get('temp_contact_list',[]);
        array_splice($temp_list,$index,1);
        Yii::$app->session->set('temp_contact_list',$temp_list);

        return $this->apiResponse([
            'code' => 200
        ]);
    }


    /**
     * 获取模型
     * @param int $id
     * @return HotelContact|static
     */
    public function getModel($id=0){
        if (empty($id)){
            return new HotelContact();
        }else{
            return HotelContact::findOne($id);
        }
    }


    //获取属性
    public function getThemeId(){
        return Yii::$app->request->get('theme_id',null);
    }
    public function getTheme(){
        return Yii::$app->request->get('theme',null);
    }
}
