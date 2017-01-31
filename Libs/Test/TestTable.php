<?php
class Libs_Test_TestTable {
    private static $tableName = 'test';
    
    /**
     * 检测是否存在
     * @return boolean
    */
    public static function checkIt($where = '') {
        $flag = false;
        $flag = Db_Test::checkIt(self::$tableName, $where);
        return $flag;
    }
    
    /**
     * 插入信息
     * @param   array       $col    插入数据数组
     * @param   boolean     $isInsertId   是否返回插入数据的id值
     * @return  boolean/integer
     */
    public static function insertData($col = array(), $isInsertId = false) {
        $result = false;
        $result = Db_Test::insertData(self::$tableName, $col, $isInsertId);
        return $result;
    }
    
    /**
     * 更新信息
     * @param   array   $col    更新的字段数组
     * @param   string  $where  更新的条件
     * @param   int     $limit  更新的数量
     * @return  boolean
     */
    public static function updateData($col = array(), $where = '', $limit = 1) {
        $flag = false;
        $flag = Db_Test::updateData(self::$tableName, $col, $where, $limit);
        return $flag;
    }
    
    /**
     * 删除信息
     * @param  string   $where  删除的条件
     * @param  int      $limit  删除的数量
     * @author  chai.jiawei <chai.jiawei@zol.com.cn>
     * @date    2016-04-14
     * @return  boolean
    */
    public static function deleteData($where = '', $limit = 1) {
        $flag = false;
        $flag = Db_Test::deleteData(self::$tableName, $where, $limit);
        return $flag;
    }
    
    /**
     * 获取信息
     * @param   array        $col               要获取数据的字段
     * @param   string       $where             查询条件
     * @param   array        $orderby           排序数据
     * @param   int          $start             开始位置
     * @param   int          $number            返回长度
     * @author  chai.jiawei <chai.jiawei@zol.com.cn>
     * @date    2016-04-14
     * @return  array/boolean
     */
    public static function getData($col = array(), $where = '', $orderby = array(), $start = 0, $number = 0) {
        $result = false;
        $result = Db_Test::getData(self::$tableName, $col, $where, $orderby, $start, $number);
        return $result;
    }
    
    /**
     * 获取数量
     * @param   string  $where  查询条件
     * @author  chai.jiawei <chai.jiawei@zol.com.cn>
     * @date    2016-04-14
     * @return  integer
     */
    public static function getCount($where = '') {
        $number = 0;
        $number = Db_Test::getCount(self::$tableName, $where);
        return $number;
    }
    
    /**
     * 获取单个字段
     * @param   string       $fileName          字段名
     * @param   string       $where             查询条件
     * @param   array        $orderby           排序数据
     * @author  chai.jiawei <chai.jiawei@zol.com.cn>
     * @date    2016-04-14 
     * @return  string
     */
    public static function getOneField($fileName = '', $where = '', $orderby = array()) {
        $result = '';
        $result = Db_Test::getOneField(self::$tableName, $fileName, $where, $orderby);
        return $result;
    }
    
    /**
     * 测试sql语句
     * @author  chai.jiawei <chai.jiawei@zol.com.cn>
     * @date    2016-04-14
     * @return  string
     */
    public static function getSql() {
        $sql = '';
        $sql = Db_Test::getSql();
        return $sql;
    }

}
