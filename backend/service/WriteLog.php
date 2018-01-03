<?php

namespace backend\service;

/**
 * 将错误日志写入runtime（Yii/backend/runtime/....）
 * Class WriteLog
 * @package app\service
 * @author:ys
 * @date : 2017年10月27日
 */
class WriteLog
{
    //默认日志文件名（默认为yyyy/mm/yyyy-mm-dd.log）
    public static function _dateLogName()
    {
        return date('Y/m/Y-m-d').'log';
    }
    //对存储路径进行处理
    public static function LogWritePathHandle($LogPath, $LogFile = '')
    {
        $path_info = trim($LogPath, '/').'/';
        $path_info .= empty($LogFile) ? self::_dateLogName() : $LogFile;
        return $path_info;
    }
    //对错误日志文件的存储信息进行处理编辑
    public static function LogWriteDataHandle($LogeData, $IsAppendServiceInfo = true)
    {
        $result_str_info = '';
        //判断存储信息是否为对象
        if (is_object($LogeData)) {
            //将对象转化为字符串
            $result_str_info = $LogeData.'';
        //判断存储信息是否为数组
        } else if (is_array($LogeData)) {
            $result_str_info = print_r($LogeData, true);
        }
        //判断是否追加服务器信息（默认追加服务器信息）
        $IsAppendServiceInfo && ( $result_str_info.= PHP_EOL."SERVICE_INFO::".print_r($_SERVER, true));
        return $result_str_info;
    }
    //将错误信息写入日志
    public static function WriteLogs($LogPath, $logInfo, $mode='a+', $chmod=0777)
    {
        //缓存路径（/www/newadmin/backend/runtime/logs/.....）
        $path = \Yii::$app->runtimePath.'/logs/'.$LogPath;
        $logDir = dirname($path);//获取路径信息（目录部分）
        //判断指定文件是否存在且为目录
        if (!is_dir($logDir)) {
            @mkdir($logDir, $chmod,true);//创建目录，递归赋值权限（777）
            @chmod($logDir, $chmod);
        }
        //判断文件是否存在
        if ( !file_exists($path) ) {
            @touch($path);//创建文件
            @chmod($path, $chmod);//给文件指定权限
        }
        //打开文件
        $f = @fopen($path, $mode);//以读写方式打开文件
        $date = date('Y-m-d H:i:s');//获取当前时间（日志写入时间）
        @fwrite($f, $date. '=>' .$logInfo. PHP_EOL);
        @fclose($f);
        return true;
    }
}