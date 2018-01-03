<?php
// 引入鉴权类
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;

/**
 * Uploader.class.php
 * 将上传的文件直接传到七牛服务器【其中沿用了百度编辑器uedtior中上传附件的代码】
 * @author : 付燕飞
 * @date   : 2017-4-7 15:25:54
 */
class Uploader
{
    private $params; //$_GET-前台页面传递过来的参数值   2017年3月23日10:57:56付燕飞新增参数
    private $oriName; //原始文件名
    private $fileName; //新文件名
    private $fullName; //完整文件名,即从当前配置目录开始的URL
    private $fileSize; //文件大小
    private $fileType; //文件类型
    private $stateInfo; //上传状态信息,
    private $stateMap = array( //上传状态映射表，国际化用户需考虑此处数据的国际化
        "SUCCESS", //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
        "图片格式最少640*480",
        "文件大小超出 upload_max_filesize 限制",
        "文件大小超出 MAX_FILE_SIZE 限制",
        "文件未被完整上传",
        "没有文件被上传",
        "上传文件为空",
        "ERROR_TMP_FILE" => "临时文件错误",
        "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件",
        "ERROR_SIZE_EXCEED" => "文件大小超出网站限制",
        "ERROR_TYPE_NOT_ALLOWED" => "文件类型不允许",
        "ERROR_CREATE_DIR" => "目录创建失败",
        "ERROR_DIR_NOT_WRITEABLE" => "目录没有写权限",
        "ERROR_FILE_MOVE" => "文件保存时出错",
        "ERROR_FILE_NOT_FOUND" => "找不到上传文件",
        "ERROR_WRITE_CONTENT" => "写入文件内容错误",
        "ERROR_UNKNOWN" => "未知错误",
        "ERROR_DEAD_LINK" => "链接不可用",
        "ERROR_HTTP_LINK" => "链接不是http链接",
        "ERROR_HTTP_CONTENTTYPE" => "链接contentType不正确",
        "INVALID_URL" => "非法 URL",
        "INVALID_IP" => "非法 IP",
    );

    /**
     * 构造函数
     * @param string $fileField 表单名称
     * @param array $config 配置项
     * @param array $params $_GET（即为前台页面传递过来的参数值）     2017年3月23日10:56:58付燕飞新增加的参数
     * @param bool $base64 是否解析base64编码，可省略。若开启，则$fileField代表的是base64编码的字符串表单名
     */
    public function __construct($params)
    {
        $this->params = $params;   //$_REQUEST （即为前台页面传递过来的参数值）
        $this->upFile();
//        $this->stateMap['ERROR_TYPE_NOT_ALLOWED'] = iconv('unicode', 'utf-8', $this->stateMap['ERROR_TYPE_NOT_ALLOWED']);
    }


    /**
     * 上传文件的主处理方法
     * @return mixed
     */
    private function upFile()
    {
        // 上传的图片信息$_FILES里面的东西
        $file = $this->params;

        $this->oriName = $file['name']; // 原始图片名
        $this->fileSize = $file['size']; // 原始图片大小
        $this->fileType = $this->getFileExt(); // 原始图片后缀

        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $secretKey = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 要上传的空间
        $bucket = 'imgs';

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);

        // 要上传文件的本地路径
        $filePath = $file['tmp_name'];
        $img_size=getimagesize($filePath);
        if($img_size[0]<640||$img_size[1]<480){
            return $this->stateInfo=$this->stateMap[1];
        }
        // 上传到七牛后保存的文件名（命名规则：前缀-id-time().6位随机数）付燕飞2017年3月23日11:01:59修改
        $key = 'agent'."_".$this->params['house_id']."_".time().rand(10000,99999).$this->fileType;
        $this->fullName = 'http://img.tgljweb.com/'.$key; // 这个是图片地址。要访问这个地址显示图片
        $this->fileName = $key; // 这个可以理解为你鼠标放到图片上显示的title自己可以定义要显示什么

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_MOVE");
        } else {
            $this->stateInfo = $this->stateMap[0];
        }

    }

    /**
     * 上传错误检查
     * @param $errCode
     * @return string
     */
    private function getStateInfo($errCode)
    {
        return !$this->stateMap[$errCode] ? $this->stateMap["ERROR_UNKNOWN"] : $this->stateMap[$errCode];
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    private function getFileExt()
    {
        return strtolower(strrchr($this->oriName, '.'));
    }

    /**
     * 获取当前上传成功文件的各项信息
     * @return array
     */
    public function getFileInfo()
    {
        return array(
            "state" => $this->stateInfo,
            "url" => basename($this->fullName),
            "title" => $this->fileName,
            "original" => $this->oriName,
            "type" => $this->fileType,
            "size" => $this->fileSize,
        );
    }

}