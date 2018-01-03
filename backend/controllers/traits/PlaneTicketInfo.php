<?php
/**
 * Created by PhpStorm.
 * User: ys
 * Date: 2017/9/27
 * Time: 20:31
 */
namespace backend\controllers\traits;

use backend\components\SmsConsts;
use backend\helper\SmsHelper;
use backend\service\WriteLog;

trait PlaneTicketInfo{
    /**
     * @加密校验
     */
    private function ShaPlaneTicketValue($c_time)
    {
        $publicKey = PLANE_TICKET_TOKEN;
        $sha_str = sha1($publicKey.$c_time);
        return $sha_str;
    }
    /**
     * @模拟post提交
     */
    public function sub_post($url, $data)
    {
        $requestData = is_array($data) ? http_build_query($data) : $data;
        $login_curl = curl_init();
        //设置资源相关选项
        curl_setopt($login_curl, CURLOPT_URL, $url);
        curl_setopt($login_curl, CURLOPT_POST, 1);//当前是post请求
        curl_setopt($login_curl, CURLOPT_POSTFIELDS, $requestData);
        //获取返回的内容 不输出
        curl_setopt($login_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($login_curl, CURLOPT_HTTPHEADER, array(
//                'Content-Type: application/json',
                'Content-Length: ' . strlen($requestData)
            )
        );
        //发出请求
        $interface = curl_exec($login_curl);
//        $error = curl_error($login_curl);
        //转换json返回的数据
        $json = json_decode($interface, true);
//        $data = [
//            'error' => $error,
//            'json'  => $json,
//            'info'  => $interface
//        ];
//        dd($data);
        return $json;
    }
    /**
     * @大交通-机票订单列表页（plane-ticket-order/index）-顶部保险状态筛选条件
     */
    public static function InsuranceSelectOptions()
    {
        $result_arr = [
            1 => '未购保',
            2 => '已出保',
            3 => '已退保',
            4 => '出保失败',
            5 => '退保失败',
            6 => '部分出保',
        ];
        return $result_arr;
    }
    /**
     * @json数据返回
     */
    public function ResponseJson($code=0, $data=[], $msg='')
    {
        $info = [
            'code' => $code,
            'data' => $data,
            'msg'  => $msg,
        ];
        return json_encode($info, JSON_UNESCAPED_UNICODE);
    }
    /**
     * @发送短信（乘机人人工退保成功）
     */
    public function RefundInsuranceSuccessSendSms($data)
    {
        $insurance_name = $data['insurance_name'];//保险公司名
        $emplane_name = $data['emplane_name'];//乘机人姓名
        $insurance_code = $data['insurance_code'];//乘机人相对应保单号
        $supplier_mobile = $data['supplier_mobile'];//保险公司咨询电话
        $mobile_phone = $data['emplane_mobile'];//乘机人联系电话
        $contentU = sprintf(SmsConsts::PLANE_TICKET_REFUND_INSURANCE_SERVICE_SUCCESS, $insurance_name, $emplane_name, $insurance_code, $supplier_mobile);
        $resU = SmsHelper::sendSms($mobile_phone,$contentU);
        if($resU){
            $res = [
                'code' => '200',
                'msg' => 'success',
            ];
            $status = true;
        } else{
            $res = [
                'code' => '1009',
                'msg' => '短信发送失败',
            ];
            $status = false;
        }
        return $status;
    }
    /**
     * @发送短信（乘机人人工出保成功）
     */
    public function AddInsuranceSuccessSendSms($data)
    {
        $insurance_name = $data['insurance_name'];//保险公司名
        $emplane_name = $data['emplane_name'];//乘机人姓名
        $insurance_code = $data['insurance_code'];//乘机人相对应保单号
        $supplier_mobile = $data['supplier_mobile'];//保险公司咨询电话
        $mobile_phone = $data['emplane_mobile'];//乘机人联系电话
        $contentU = sprintf(SmsConsts::PLANE_TICKET_ADD_INSURANCE_SERVICE_SUCCESS, $insurance_name, $emplane_name, $insurance_code, $supplier_mobile);
        $resU = SmsHelper::sendSms($mobile_phone,$contentU);
        if($resU){
            $res = [
                'code' => '200',
                'msg' => 'success',
            ];
            $status = true;
        } else{
            $res = [
                'code' => '1009',
                'msg' => '短信发送失败',
            ];
            $status = false;
        }
        return $status;
    }
    /**
     * @群发邮件（人工补出保异常 + 人工退保异常）
     * @$post_data [
     *      'title',//邮件标题
     *      'content',//邮件内容
     *  ]
     */
    public function SendPlaneInsuranceHandleAbnormalPost($post_data = [], $key = 'handle_insurance_abnormal_post')
    {
        //群发邮件接收人（多人数组array('*****.qq.com', '*****.tgljweb.com', '*****.163.com'）
        $users = $this->PlaneInsuranceAbnormalReceivePersonData($key);
        //对邮件发送相关内容进行处理（将数组转化为输出格式写入）
        $post_data = $this->HandlePostContent($post_data);
//        dd($post_data);
        //邮件标题
        $post_title = $post_data['title'];
        $post_content = $post_data['content'];
        $messages = [];
        foreach ($users as $user) {
            $messages[] = \Yii::$app->mailer->compose()
                ->setTo($user)
                ->setSubject($post_title)
                ->setHtmlBody($post_content);//此处可加入HTML标签
        }
        return \Yii::$app->mailer->sendMultiple($messages);
    }
    /**
     * @获取邮件群发接收人邮箱信息
     * @ array('*****.qq.com', '*****.tgljweb.com', '*****.163.com')
     */
    public function PlaneInsuranceAbnormalReceivePersonData($key = '')
    {
        //邮件发送相关人员总信息
        $post_data = \Yii::$app->params['plane_ticket_post_person_list'];
        return $post_data[$key];
    }
    /**
     * @邮件内容处理
     * @$post_data [
     *      'title',//邮件标题
     *      'content',//邮件内容
     *  ]
     */
    public function HandlePostContent($post_data)
    {
        $post_data['title'] = empty($post_data['title']) ? '': (is_array($post_data['title']) ? print_r($post_data['title'], true) : $post_data['title']);
        $post_data['content'] = '<pre>'.(empty($post_data['content']) ? '' : (is_array($post_data['content']) ? print_r($post_data['content'], true) : $post_data['title'])).'</pre>';
        return $post_data;
    }
    /**
     * @机票邮件发送异常，写入日志系统（后台日志写入功能模块：人工补出保失败发送警示邮件 + 人工退保失败发送警示邮件）
     * $LogPath 日志缓存路径
     * $logInfo 日志缓存信息
     * $fileName 日志名称（默认空则命名为当日日期 yyyy-mm-dd.log）
     */
    public function PlaneTicketPostAbnormalWriteLogs($logInfo, $LogPath='', $fileName='')
    {
        //日志路径信息处理
        $path = WriteLog::LogWritePathHandle($LogPath, $fileName);
        //日志内容信息处理
        $log_content = WriteLog::LogWriteDataHandle($logInfo);
        //将处理后的信息写入日志
        $write_status = WriteLog::WriteLogs($path, $log_content);
        return $write_status;
    }
    /**
     * @乘机人证件类型转化为保险投保人证件类型
     * @$param $code :乘机人证件类（0 身份证,1 护照,2 军官证）
     * @$return $code :保险投保人证件类型（0.身份证  1.临时身份证  2.护照  3.军官证  4.回乡证  5.台胞证）
     */
    public static function CardTypeToCerdType($code)
    {
        $card_arr = [
            0 => 0,//身份证
            1 => 2,//护照
            2 => 3,//军官证
        ];
        return isset($card_arr[$code]) ? $card_arr[$code] : false;
    }
    /**
     * @根据乘机人的姓名+身份证号，通过sha1()加密，截取前8位，作为唯一识别码，对照个人信息
     * @参考对象git commit 唯一记录编码
     * @$params $name:姓名
     * @$params $code:身份证号
     */
    public function CodeNameToShaPersonInfo($name, $code)
    {
        return substr(sha1($name.$code), 0, 8);
    }
}