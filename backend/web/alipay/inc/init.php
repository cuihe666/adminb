<?php
/**
 * * Init
 */
if (!defined('IN_AMAP')) logger(302);
define('ROOT_PATH', str_replace('inc/init.php', '', str_replace('\\', '/', __FILE__)));
include_once ROOT_PATH.'inc/config.php';
include_once ROOT_PATH.'inc/function.php';
include_once ROOT_PATH.'inc/db_sql.php';
//时区
if (function_exists('date_default_timezone_set')) {
    @date_default_timezone_set("PRC");
}

function db_connect()
{
    global $lp_db_server, $lp_db_username, $lp_db_password, $lp_db_dbname, $lp_db_port, $lp_db_char, $lp_db_ver;
    $dblocalhost = $lp_db_server;
    //端口
    if ($lp_db_port) {
        $dblocalhost .= ":" . $lp_db_port;
    }
    $link = @mysql_connect($dblocalhost, $lp_db_username, $lp_db_password);
    if (!$link) logger(304);
    //编码
    if ($lp_db_ver >= '4.1') {
        $q = '';
        if ($lp_db_char) {
            $q = 'character_set_connection=' . $lp_db_char . ',character_set_results=' . $lp_db_char . ',character_set_client=binary';
        }
        if ($lp_db_ver >= '5.0') {
            $q .= (empty ($q) ? '' : ',') . 'sql_mode=\'\'';
        }
        if ($q) {
            @mysql_query('SET ' . $q);
        }
    }
    @mysql_select_db($lp_db_dbname);
    return $link;
}

//设置编码
function DoSetDbChar($lp_db_char)
{
    if ($lp_db_char && $lp_db_char != 'auto') {
        @mysql_query("set names '" . $lp_db_char . "';");
    }
}

function db_close(

)
{
    global $link;
    @mysql_close($link);
}

?>