<?php
namespace console\lib;

/**
 * 公用工具类
 */
class   Common {
	
	/**
	 *	设置头信息 
	 * @param string $type	头信息类型
	 * @param string $char	字符集
	 */
	static public function setHeader($type = 'text/html',$char = 'utf-8' ){
	    $char = empty($char) ? 'utf-8' : $char;
	    switch ($type) {
	        case 'javascript':
	            header("Content-Type:application/x-javascript;charset={$char}");
	            break;
	        case 'json':
	            header("Content-Type:application/json;charset={$char}");
	            break;
	        case 'xml':
	            header("Content-type: text/xml;charset={$char}");
	            break;
	        case 'swf':
	            header("Content-type: application/x-shockwave-flash;");
	            break;
	        case 'gif':
	            header("Content-type:image/gif;");
	            break;
	        case 'jpg':
	            header("Content-type:image/jpg;");
	            break;
	        case 'png':
	            header("Content-type:image/png;");
	            break;
	        case 'css':
	            header("Content-type: text/css;charset={$char}");
	            break;
	        default:
	            header("Content-type: text/html;charset={$char}");
	    }
	}
	
	
	 /**
	  * 字符集 utf8 转 gb2312
	  */
	 static public function charsetUtf8ToGb2312($str){
	 	return !empty($str) ? iconv('utf-8','gb2312',$str) : '';
	 }
	 
	 /**
	  * 字符集 gb2312 转 utf8
	  */
	 static public function charsetGb2312ToUtf8($str){
	 	return !empty($str) ? iconv('gb2312','utf-8//TRANSLIT//IGNORE',$str) : '';
	 }

	/**
	 * 中文字符集 utf8 转 gb2312
	 */
	 static public function mbCharsetUtf8ToGb2312($str){
		 return !empty($str) ? mb_convert_encoding($str,'gb2312','utf-8') : '';
	 }

	/**
	 * 中文字符集 gb2312 转 utf8
	 */
	 static public function mbCharsetGb2312ToUtf8($str){
		 return !empty($str) ? mb_convert_encoding($str,'utf-8','gb2312') : '';
	 }
	 
	 /**
	  * 导出csv文件
	  * @param $fileName 导出csv文件时的文件名称
	  * @param $data 输出数据，若数据不存在，只设置header头标识为csv文件导出
	  */
	 static public function exportCsv($fileName,$data = '') {
	 	header('Content-type:text/csv');
	 	header("Content-Disposition:attachment;filename={$fileName}");
	 	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	 	header('Expires:0');
	 	header('Pragma:public');
	 	if( !empty($data) ){
	 		echo $data;
	 	}
	 }

}
