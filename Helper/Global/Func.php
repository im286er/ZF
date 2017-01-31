<?php 
class Helper_Global_Func {
    /**
     * 格式化字符串
     *
     * @param   String     $string   要处理字符串
     * @param   String     $type     $type类型 trip代表过滤掉html标签 html代表不过滤html标签
     * @return  String
     */
    public static function formatString($string = '', $type = "trip") {
        if ($string){
            switch ($type) {
                case 'trip':
                    $string = trim(strip_tags($string));
                    break;
                case 'html':
                    $string = trim(htmlspecialchars($string));
                    break;
                default :
                    $string = trim(strip_tags($string));
                    break;
            }            
        }
        
        return $string;
    }
    
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
