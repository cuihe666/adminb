<?php
namespace app\models\common;

trait CURDTrait {
    static private $_transaction = null;
    static private $_query = null;

    private function _db(){
        static $db=null;
        if( $db===null ){
            $db = self::getDb();
        }
        return $db;
    }

    //获取最后执行的sql语句
    public function getRawSql(){
        if( self::$_query instanceof \yii\db\Command){
            return self::$_query->getRawSql();
        } else if( self::$_query!==null ){
            $commandQuery = clone self::$_query;
           return $commandQuery->createCommand()->getRawSql();
        }
        return self::_db()->createCommand()->getRawSql();
    }

    //数据库访问操作-添加
    //@demo echo $store->addData(['code'=>microtime(true)]);
    public function addData(array $data){
        self::$_query = self::_db()->createCommand()->insert(self::tableName(), $data);
        self::$_query->execute();
        return self::_db()->getLastInsertID();
    }

    //数据库访问操作-修改
    //@demo $store->updateData(['region_name'=>'test'],['id'=>'1']);
    public function updateData(array $data,$where){
        self::$_query = self::_db()->createCommand()->update(self::tableName(), $data, $where);
        return self::$_query->execute();
    }

    //数据库访问操作-删除
    //@demo $store->deleteData(['id'=>'1']);
    public function deleteData($where){
        self::$_query = self::_db()->createCommand()->delete(self::tableName(), $where);
        return self::$_query->execute();
    }

    //数据库访问操作-查询一条数据
    public function getDataByOne($where,$filed='*'){
        if( empty($where) ){
            return [];
        }
        self::$_query   = $this->find()->select($filed)->where($where);
        $res            = self::$_query->asArray()->one();
        return !empty($res) && is_array($res)  ? $res  : [];
    }

    //数据库访问操作-查询更多数据
    public function getDataByAll($where,$filed='*'){
        if( empty($where) ){
            return [];
        }
        self::$_query   = $this->find()->select($filed)->where($where);
        $res            = self::$_query->asArray()->all();
        return !empty($res) && is_array($res)  ? $res  : [];
    }

    //数据库访问操作-执行查询sql-结果集1条
    public function querySqlForOne($bindSql,array $bindParams){
        self::$_query   = self::_db()->createCommand($bindSql)->bindValues($bindParams);
        $res            = self::$_query->queryOne();
        return isset($res) && is_array($res) ? $res : [];
    }

    //静态方法:数据库访问操作-执行查询sql-结果集1条
    static public function static_querySqlForOne($bindSql,array $bindParams){
        self::$_query   = self::_db()->createCommand($bindSql)->bindValues($bindParams);
        $res            = self::$_query->queryOne();
        return isset($res) && is_array($res) ? $res : [];
    }

    //数据库访问操作-执行查询sql-结果集多条
    public function querySqlForAll($bindSql,array $bindParams){
        self::$_query   = self::_db()->createCommand($bindSql)->bindValues($bindParams);
        $res            = self::$_query->queryAll();
        return isset($res) && is_array($res) ? $res : [];
    }

    //数据库访问操作-执行操作sql
    public function execSql($bindSql,array $bindParams){
        self::$_query   = self::_db()->createCommand($bindSql)->bindValues($bindParams);
        return self::$_query->execute();
    }

    //数据库访问操作-执行插入
    public function execInsertForOne($tableName,array $data){
        self::$_query   = self::_db()->createCommand()->insert('`'.$tableName.'`', $data);
        self::$_query->execute();
        return self::_db()->getLastInsertID();
    }


    //数据库访问操作-执行修改
    public function execUpdateData($tableName,array $data,$where){
        self::$_query   = self::_db()->createCommand()->update('`'.$tableName.'`', $data, $where);
        return self::$_query->execute();
    }

    //数据库访问操作-执行删除
    public function execDeleteData($tableName,$where){
        self::$_query   = self::_db()->createCommand()->delete('`'.$tableName.'`', $where);
        return self::$_query->execute();
    }

    //开启事物
    public function transactionBegin(){
        $db = self::_db();
        self::$_transaction = $db->beginTransaction();
    }

    //回滚事物
    public function transactionRollBack(){
        self::$_transaction->rollBack();
    }

    //提交事物
    public function transactionCommit(){
        self::$_transaction->commit();
    }

}

