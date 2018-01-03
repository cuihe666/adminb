<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/19
 * Time: 下午1:29
 */

namespace backend\traits;


use yii\web\Response;

trait AjaxTrait
{

    //统一响应json 格式内容
    public function apiResponse($data=[]){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return \Yii::$app->response->data = $data;
    }

    /**
     * 重定向并弹出信息
     * @param $route
     * @param null $message
     * @param string $type
     * @return \yii\web\Response
     */
    public function redirectAndMsg($route,$message=null,$type='error'){
        if($message !== null){
//            Yii::$app->session->setFlash($type,$error);
            \Yii::$app->session->setFlash('c_message',['type'=>$type,'message' => $message,'method'=>'alert']);
        }
        return $this->redirect($route);
    }

    /**
     * 直接弹出信息
     * @param string $type
     * @param $message
     * @param string $method
     */
    public function alertMsg($type="error",$message,$method='alert'){
        \Yii::$app->session->setFlash('c_message',['type'=>$type,'message' => $message,'method'=>$method]);
    }

}