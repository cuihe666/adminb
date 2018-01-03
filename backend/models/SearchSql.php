<?php
namespace backend\models;

use yii\base\Model;

class SearchSql extends Model
{
    protected static function _db()
    {
        $db = \Yii::$app->db;
        return $db;
    }
    //查询单条信息
    public static function _SearchOneData($sql, $arr = NULL)
    {
        $data = self::_db()->createCommand($sql)
            ->bindValues($arr)
            ->queryOne();
        return $data;
    }
    //查询字段scalar
    public static function _SearchScalarData($sql, $arr = NULL)
    {
        $data = self::_db()->createCommand($sql)
            ->bindValues($arr)
            ->queryScalar();
        return $data;
    }
    //查询多条信息
    public static function _SearchAllData($sql, $arr = NULL)
    {
        if (isset($arr)) {
            $data = self::_db()->createCommand($sql)
                ->bindValues($arr)
                ->queryAll();
        } else {
            $data = self::_db()->createCommand($sql)->queryAll();
        }
        return $data;
    }
    //修改信息 update
    public static function _UpdateSqlExecute($table, $modify, $rule = NULL)
    {
        if (isset($rule)) {
            $status = self::_db()->createCommand()
                ->update('`'.$table.'`', $modify, $rule)
                ->execute();
        } else {
            $status = self::_db()->createCommand()
                ->update('`'.$table.'`', $modify)
                ->execute();
        }
        return $status;
    }
    //插入信息 insert
    public static function _InsertSqlExecute($table, $arr)
    {
        $id = self::_db()->createCommand()
            ->insert('`'.$table.'`', $arr)
            ->execute();
        return $id;
    }
    public static function _InsertManySqlExecute($table, $name, $data)
    {
        $id = self::_db()->createCommand()
            ->batchInsert('`'.$table.'`', $name, $data)
            ->execute();
        return $id;
    }
    //开启事务
    public static function _OpenTransaction()
    {
        $transaction = self::_db()->beginTransaction();
        return $transaction;
    }

}