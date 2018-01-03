<?php
// 浏览器友好的变量输出 | 测试使用 上线删除该方法
function dump($var, $echo = true, $label = null, $strict = true)
{
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>" . $label . htmlspecialchars($output, ENT_QUOTES) . "</pre>";
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}


//输出安全的html
function h($string, $isurl = false)
{
    $string = preg_replace('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/','',$string);
    $string = str_replace(array("\0","%00","\r"),'',$string);
    empty($isurl) && $string = preg_replace("/&(?!(#[0-9]+|[a-z]+);)/si",'&',$string);
    $string = str_replace(array("%3C",'<'),'<',$string);
    $string = str_replace(array("%3E",'>'),'>',$string);
    $string = str_replace(array('"',"'","\t",' '),array('“','‘',' ',' '),$string);
    return trim($string);
}

/**
 * +----------------------------------------------------------
 * 对查询结果集进行排序
 * +----------------------------------------------------------
 * @access public
 * +----------------------------------------------------------
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * +----------------------------------------------------------
 * @return array
+----------------------------------------------------------
 */
function list_sort_by($list, $field, $sortby = 'asc')
{
    if (is_array($list)) {
        $refer = $resultSet = array();
        foreach ($list as $i => $data)
            $refer [$i] = & $data [$field];
        switch ($sortby) {
            case 'asc' : // 正向排序
                asort($refer);
                break;
            case 'desc' : // 逆向排序
                arsort($refer);
                break;
            case 'nat' : // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ($refer as $key => $val)
            $resultSet [] = & $list [$key];
        return $resultSet;
    }
    return false;
}

//编码转换
function safeEncoding($string, $outEncoding = 'UTF-8')
{
    $encoding = "UTF-8";
    for ($i = 0; $i < strlen($string); $i++) {
        if (ord($string{$i}) < 128)
            continue;

        if ((ord($string{$i}) & 224) == 224) {
//第一个字节判断通过
            $char = $string{++$i};
            if ((ord($char) & 128) == 128) {
//第二个字节判断通过
                $char = $string{++$i};
                if ((ord($char) & 128) == 128) {
                    $encoding = "UTF-8";
                    break;
                }
            }
        }
        if ((ord($string{$i}) & 192) == 192) {
//第一个字节判断通过
            $char = $string{++$i};
            if ((ord($char) & 128) == 128) {
//第二个字节判断通过
                $encoding = "GBK";
                break;
            }
        }
    }

    if (strtoupper($encoding) == strtoupper($outEncoding))
        return $string;
    else
        return iconv($encoding, $outEncoding, $string);
}

/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings, $start, $length)
{
    if (function_exists('mb_substr') && function_exists('mb_strlen')) {
        $sub_str = mb_substr($strings, $start, $length, 'utf8');
        return mb_strlen($sub_str, 'utf8') < mb_strlen($strings, 'utf8') ? $sub_str : $sub_str;
    }
    $str = substr($strings, $start, $length);
    $char = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        if (ord($str[$i]) >= 128)
            $char++;
    }
    $str2 = substr($strings, $start, $length + 1);
    $str3 = substr($strings, $start, $length + 2);
    if ($char % 3 == 1) {
        if ($length <= strlen($strings)) {
            $str3 = $str3 .= '';
        }
        return $str3;
    }
    if ($char % 3 == 2) {
        if ($length <= strlen($strings)) {
            $str2 = $str2 .= '';
        }
        return $str2;
    }
    if ($char % 3 == 0) {
        if ($length <= strlen($strings)) {
            $str = $str .= '';
        }
        return $str;
    }
}

//异常&LOG
function exception_handler($result,$sql = "")
{
    global $errormsg;

    $rs = "[alipay] [" . date('Y-m-d H:i:s') . "]  [" . $result ."]  [". $sql ."]\n";
    error_log($rs, 3, "/logs/pay/error.log.".date("YmdH"));
}

function logger($result,$orderNo="",$status="",$list=[], $ok='fail') {
    global $empire,$errormsg;
    if (is_numeric($result))
    {
        $result = $errormsg[$result];
    }
    $log = [
        'order_num'     => $orderNo,
        'trade_status'  => $status,
        'msg'           => $result,
        'ok'            => $ok,
        'data'          => json_encode($list),
        'ctime'         => time()
    ];
    $empire->esinsert('pay_note',$log);
}

// 获取数据兼容file_get_contents与curl
function vita_get_url_content($url)
{
    if (function_exists('curl_init')) {
        $ch = curl_init();
        $timeout = 8;
        session_write_close();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $file_contents = curl_exec($ch);
        if ($file_contents == false)
            logger(203);
        curl_close($ch);
        return $file_contents;
    } else
        logger(204);
}

function xmlNameSpaceToArray(SimpleXmlIterator $xml, $nameSpaces = Null)
{
    $output = Null;
    $preparedArray = array();
    for ($xml->rewind(); $xml->valid(); $xml->next()) {
        $key = $xml->key();
        if (!isset($preparedArray[$key])) {
            $preparedArray[$key] = array();
            $i = 0;
        } else $i = count($preparedArray[$key]);
        $simple = true;
        foreach ($xml->current()->attributes() as $k => $v) {
            $preparedArray[$key][$i][$k] = (string)$v;
            $simple = false;
        }
        if ($nameSpaces) foreach ($nameSpaces as $nid => $name) {
            foreach ($xml->current()->attributes($name) as $k => $v) {
                $preparedArray[$key][$i][$nid . ':' . $k] = (string)$v;
                $simple = false;
            }
        }
        if ($xml->hasChildren()) {
            if ($simple) $preparedArray[$key][$i] = xmlNameSpaceToArray($xml->current(), $nameSpaces);
            else $preparedArray[$key][$i]['content'] = xmlNameSpaceToArray($xml->current(), $nameSpaces);
        } else {
            if ($simple) $preparedArray[$key][$i] = strval($xml->current());
            else $preparedArray[$key][$i]['content'] = strval($xml->current());
        }
        $i++;
    }
    $output = $preparedArray;
    return $preparedArray;
}

function xmlToArray($xmlFilePath)
{
    $xml = new SimpleXmlIterator($xmlFilePath, null, true);
    $nameSpaces = $xml->getNamespaces(true);
    $output = xmlNameSpaceToArray($xml, $nameSpaces);
    return $output;
}
?>
