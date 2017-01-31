<?php 
class Helper_Global_Func {
    public static function clearPageUrl($params = array()) {
        # 初始化参数
        $str = '?';
        $outStr = $_SERVER['SCRIPT_NAME'];
        # 构造链接
        if (is_array($params) && !empty($params)) {
            foreach ($params as $paramsKey => $paramsVal) {
                if ($paramsVal && $paramsKey != 'page') {
                    $outStr .= $str . $paramsKey . '=' . htmlspecialchars($paramsVal);
                    $str = '&';
                }
            }
        }
        # 返回参数
        return $outStr;
    }
}
