<?php
if (!defined('IN_AMAP')) logger(302);
class mysqlquery
{
    var $sql;//sql语句执行结果
    var $query;//sql语句
    var $num;//返回记录数
    var $r;//返回数组
    var $id;//返回数据库id号
    //执行mysql_query()语句
    function query($query)
    {
        if(!$this->sql=mysql_query($query))
        {
            logger(208);
        }
        return $this->sql;
    }
    //执行mysql_query()语句2
    function query1($query)
    {
        $this->sql=mysql_query($query);
        return $this->sql;
    }
    //执行mysql_fetch_array()
    function fetch($sql,$type=null)//此方法的参数是$sql就是sql语句执行结果
    {
        if($type == null)
        $this->r=mysql_fetch_array($sql);
        else
            $this->r=mysql_fetch_array($sql,MYSQL_ASSOC);
        return $this->r;
    }
    //执行fetchone(mysql_fetch_array())
    //此方法与fetch()的区别是:1、此方法的参数是$query就是sql语句
    //2、此方法用于while(),for()数据库指针不会自动下移，而fetch()可以自动下移。
    function fetch1($query)
    {
        $this->sql=$this->query($query);
        $this->r=mysql_fetch_array($this->sql);
        return $this->r;
    }
    //简化查询select
    function select($sql)
    {
        $data  = array();
        $query = $this->query1($sql);
        while ($row = $this->fetch($query,1)) {
            $data[] = $row;
        }
        return $data;
    }
    //执行mysql_num_rows()
    function num($query)//此类的参数是$query就是sql语句
    {
        $this->sql=$this->query($query);
        $this->num=mysql_num_rows($this->sql);
        return $this->num;
    }
    //执行numone(mysql_num_rows())
    //此方法与num()的区别是：1、此方法的参数是$sql就是sql语句的执行结果。
    function num1($sql)
    {
        $this->num=mysql_num_rows($sql);
        return $this->num;
    }
    //数组写入
    function esinsert($table, $row)
    {
        $sqlfield = $sqlvalue = '';
        foreach($row as $key => $value) {
            $sqlfield .= $key . ",";
            if(strstr($value,'\\\\'))
                $value = str_replace('\\\\','\\',$value);
            $sqlvalue .= "'" . $value . "',";
        }
        if ($this->sql=$this->query("INSERT INTO `" . $table . "`(" . substr($sqlfield, 0, -1) . ") VALUES (" . substr($sqlvalue, 0, -1) . ")")) {
            return true;
        } else return false;
    }
    //执行numone(mysql_num_rows())
    //统计记录数
    function gettotal($query)
    {
        $this->r=$this->fetch1($query);
        return $this->r['total'];
    }
    //执行free(mysql_result_free())
    //此方法的参数是$sql就是sql语句的执行结果。只有在用到mysql_fetch_array的情况下用
    function free($sql)
    {
        mysql_free_result($sql);
    }
    //执行seek(mysql_data_seek())
    //此方法的参数是$sql就是sql语句的执行结果,$pit为执行指针的偏移数
    function seek($sql,$pit)
    {
        mysql_data_seek($sql,$pit);
    }
    //执行id(mysql_insert_id())
    function lastid()//取得最后一次执行mysql数据库id号
    {
        $this->id=mysql_insert_id();
        return $this->id;
    }
}
?>