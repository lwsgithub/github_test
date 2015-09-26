<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com>                        |
// |          Your Name <you@example.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id:$

if (!defined('THINK_PATH')) define('THINK_PATH', './ThinkPHP');
if (!defined('APP_NAME')) define('APP_NAME', 'ThinkPHP_test');
if (!defined('APP_PATH')) define('APP_PATH', '.');
if (!defined('MEMORY_LIMIT_ON')) define('MEMORY_LIMIT_ON', true);
if (!defined('RUNTIME_PATH')) define('RUNTIME_PATH', './Runtime/');
if (!defined('MAGIC_QUOTES_GPC')) define('MAGIC_QUOTES_GPC', false);
if (!defined('IS_CGI')) define('IS_CGI', 0);
if (!defined('IS_WIN')) define('IS_WIN', 1);
if (!defined('IS_CLI')) define('IS_CLI', 0);
if (!defined('_PHP_FILE_')) define('_PHP_FILE_', '/ThinkPHP_test/index.php');
if (!defined('__ROOT__')) define('__ROOT__', '');
if (!defined('URL_COMMON')) define('URL_COMMON', 0);
if (!defined('URL_PATHINFO')) define('URL_PATHINFO', 1);
if (!defined('URL_REWRITE')) define('URL_REWRITE', 2);
if (!defined('URL_COMPAT')) define('URL_COMPAT', 3);
if (!defined('THINK_VERSION')) define('THINK_VERSION', '2.2');
if (!defined('THINK_RELEASE')) define('THINK_RELEASE', '20120323');
if (!defined('CACHE_DIR')) define('CACHE_DIR', 'Cache');
if (!defined('HTML_DIR')) define('HTML_DIR', 'Html');
if (!defined('CONF_DIR')) define('CONF_DIR', 'Conf');
if (!defined('LIB_DIR')) define('LIB_DIR', 'Lib');
if (!defined('LOG_DIR')) define('LOG_DIR', 'Logs');
if (!defined('LANG_DIR')) define('LANG_DIR', 'Lang');
if (!defined('TEMP_DIR')) define('TEMP_DIR', 'Temp');
if (!defined('TMPL_DIR')) define('TMPL_DIR', 'Tpl');
if (!defined('TMPL_PATH')) define('TMPL_PATH', './Tpl/');
if (!defined('HTML_PATH')) define('HTML_PATH', './Html/');
if (!defined('COMMON_PATH')) define('COMMON_PATH', './Common/');
if (!defined('LIB_PATH')) define('LIB_PATH', './Lib/');
if (!defined('CACHE_PATH')) define('CACHE_PATH', './Runtime/Cache/');
if (!defined('CONFIG_PATH')) define('CONFIG_PATH', './Conf/');
if (!defined('LOG_PATH')) define('LOG_PATH', './Runtime/Logs/');
if (!defined('LANG_PATH')) define('LANG_PATH', './Lang/');
if (!defined('TEMP_PATH')) define('TEMP_PATH', './Runtime/Temp/');
if (!defined('DATA_PATH')) define('DATA_PATH', './Runtime/Data/');
if (!defined('VENDOR_PATH')) define('VENDOR_PATH', './ThinkPHP/Vendor/');
if (!defined('BUILD_DIR_SECURE')) define('BUILD_DIR_SECURE', false);
function N($key, $step = 0) {
    static $_num = array();
    if (!isset($_num[$key])) {
        $_num[$key] = 0;
    }
    if (empty($step)) return $_num[$key];
    else $_num[$key] = $_num[$key] + (int)$step;
}
function U($url, $params = array() , $redirect = false, $suffix = true) {
    if (0 === strpos($url, '/')) $url = substr($url, 1);
    if (!strpos($url, '://')) $url = APP_NAME . '://' . $url;
    if (stripos($url, '@?')) {
        $url = str_replace('@?', '@think?', $url);
    } elseif (stripos($url, '@')) {
        $url = $url . MODULE_NAME;
    }
    $array = parse_url($url);
    $app = isset($array['scheme']) ? $array['scheme'] : APP_NAME;
    $route = isset($array['user']) ? $array['user'] : '';
    if (defined('GROUP_NAME') && strcasecmp(GROUP_NAME, C('DEFAULT_GROUP'))) $group = GROUP_NAME;
    if (isset($array['path'])) {
        $action = substr($array['path'], 1);
        if (!isset($array['host'])) {
            $module = MODULE_NAME;
        } else {
            if (strpos($array['host'], '-')) {
                list($group, $module) = explode('-', $array['host']);
            } else {
                $module = $array['host'];
            }
        }
    } else {
        $module = MODULE_NAME;
        $action = $array['host'];
    }
    if (isset($array['query'])) {
        parse_str($array['query'], $query);
        $params = array_merge($query, $params);
    }
    if (C('APP_SUB_DOMAIN_DEPLOY')) {
        foreach (C('APP_SUB_DOMAIN_RULES') as $key => $rule) {
            if (in_array($group . "/", $rule)) $flag = true;
            if (in_array($group . "/" . $module, $rule)) {
                $flag = true;
                unset($module);
            }
            if (!isset($group) && in_array(GROUP_NAME . "/" . $module, $rule) && in_array($key, array(
                SUB_DOMAIN,
                "*"
            ))) unset($module);
            if ($flag) {
                unset($group);
                if ($key != SUB_DOMAIN && $key != "*") {
                    $sub_domain = $key;
                }
                break;
            }
        }
    }
    if (0 == strcasecmp($group, C('DEFAULT_GROUP'))) unset($group);
    if (C('URL_MODEL') > 0) {
        $depr = C('URL_PATHINFO_DEPR');
        $str = $depr;
        foreach ($params as $var => $val) $str.= $var . $depr . $val . $depr;
        $str = substr($str, 0, -1);
        $group = isset($group) ? $group . $depr : '';
        $module = isset($module) ? $module . $depr : "";
        if (!empty($route)) {
            $url = str_replace(APP_NAME, $app, __APP__) . '/' . $group . $route . $str;
        } else {
            $url = str_replace(APP_NAME, $app, __APP__) . '/' . $group . $module . $action . $str;
        }
        if ($suffix && C('URL_HTML_SUFFIX')) $url.= C('URL_HTML_SUFFIX');
    } else {
        $params = http_build_query($params);
        $params = !empty($params) ? '&' . $params : '';
        if (isset($group)) {
            $url = str_replace(APP_NAME, $app, __APP__) . '?' . C('VAR_GROUP') . '=' . $group . '&' . C('VAR_MODULE') . '=' . $module . '&' . C('VAR_ACTION') . '=' . $action . $params;
        } else {
            $url = str_replace(APP_NAME, $app, __APP__) . '?' . C('VAR_MODULE') . '=' . $module . '&' . C('VAR_ACTION') . '=' . $action . $params;
        }
    }
    if (isset($sub_domain)) {
        $domain = str_replace(SUB_DOMAIN, $sub_domain, $_SERVER['HTTP_HOST']);
        $url = "http://" . $domain . $url;
    }
    if ($redirect) redirect($url);
    else return $url;
}
function parse_name($name, $type = 0) {
    if ($type) {
        return ucfirst(preg_replace("/_([a-zA-Z])/e", "strtoupper('\\1')", $name));
    } else {
        $name = preg_replace("/[A-Z]/", "_\\0", $name);
        return strtolower(trim($name, "_"));
    }
}
function halt($error) {
    if (IS_CLI) exit($error);
    $e = array();
    if (C('APP_DEBUG')) {
        if (!is_array($error)) {
            $trace = debug_backtrace();
            $e['message'] = $error;
            $e['file'] = $trace[0]['file'];
            $e['class'] = $trace[0]['class'];
            $e['function'] = $trace[0]['function'];
            $e['line'] = $trace[0]['line'];
            $traceInfo = '';
            $time = date("y-m-d H:i:m");
            foreach ($trace as $t) {
                $traceInfo.= '[' . $time . '] ' . $t['file'] . ' (' . $t['line'] . ') ';
                $traceInfo.= $t['class'] . $t['type'] . $t['function'] . '(';
                $traceInfo.= implode(', ', $t['args']);
                $traceInfo.= ")<br/>";
            }
            $e['trace'] = $traceInfo;
        } else {
            $e = $error;
        }
        include C('TMPL_EXCEPTION_FILE');
    } else {
        $error_page = C('ERROR_PAGE');
        if (!empty($error_page)) {
            redirect($error_page);
        } else {
            if (C('SHOW_ERROR_MSG')) $e['message'] = is_array($error) ? $error['message'] : $error;
            else $e['message'] = C('ERROR_MESSAGE');
            include C('TMPL_EXCEPTION_FILE');
        }
    }
    exit;
}
function redirect($url, $time = 0, $msg = '') {
    $url = str_replace(array(
        "\n",
        "\r"
    ) , '', $url);
    if (empty($msg)) $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        if (0 === $time) {
            header("Location: " . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo ($msg);
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0) $str.= $msg;
        exit($str);
    }
}
function throw_exception($msg, $type = 'ThinkException', $code = 0) {
    if (IS_CLI) exit($msg);
    if (class_exists($type, false)) throw new $type($msg, $code, true);
    else halt($msg);
}
function debug_start($label = '') {
    $GLOBALS[$label]['_beginTime'] = microtime(TRUE);
    if (MEMORY_LIMIT_ON) $GLOBALS[$label]['_beginMem'] = memory_get_usage();
}
function debug_end($label = '') {
    $GLOBALS[$label]['_endTime'] = microtime(TRUE);
    echo '<div style="text-align:center;width:100%">Process ' . $label . ': Times ' . number_format($GLOBALS[$label]['_endTime'] - $GLOBALS[$label]['_beginTime'], 6) . 's ';
    if (MEMORY_LIMIT_ON) {
        $GLOBALS[$label]['_endMem'] = memory_get_usage();
        echo ' Memories ' . number_format(($GLOBALS[$label]['_endMem'] - $GLOBALS[$label]['_beginMem']) / 1024) . ' k';
    }
    echo '</div>';
}
function dump($var, $echo = true, $label = null, $strict = true) {
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
        echo ($output);
        return null;
    } else return $output;
}
function get_instance_of($name, $method = '', $args = array()) {
    static $_instance = array();
    $identify = empty($args) ? $name . $method : $name . $method . to_guid_string($args);
    if (!isset($_instance[$identify])) {
        if (class_exists($name)) {
            $o = new $name();
            if (method_exists($o, $method)) {
                if (!empty($args)) {
                    $_instance[$identify] = call_user_func_array(array(&$o,
                        $method
                    ) , $args);
                } else {
                    $_instance[$identify] = $o->$method();
                }
            } else $_instance[$identify] = $o;
        } else halt(L('_CLASS_NOT_EXIST_') . ':' . $name);
    }
    return $_instance[$identify];
}
function __autoload($name) {
    return Think::autoload($name);
}
function require_cache($filename) {
    static $_importFiles = array();
    $filename = realpath($filename);
    if (!isset($_importFiles[$filename])) {
        if (file_exists_case($filename)) {
            require $filename;
            $_importFiles[$filename] = true;
        } else {
            $_importFiles[$filename] = false;
        }
    }
    return $_importFiles[$filename];
}
function file_exists_case($filename) {
    if (is_file($filename)) {
        if (IS_WIN && C('APP_FILE_CASE')) {
            if (basename(realpath($filename)) != basename($filename)) return false;
        }
        return true;
    }
    return false;
}
function import($class, $baseUrl = '', $ext = '.class.php') {
    static $_file = array();
    static $_class = array();
    $class = str_replace(array(
        '.',
        '#'
    ) , array(
        '/',
        '.'
    ) , $class);
    if ('' === $baseUrl && false === strpos($class, '/')) {
        return alias_import($class);
    }
    if (isset($_file[$class . $baseUrl])) return true;
    else $_file[$class . $baseUrl] = true;
    $class_strut = explode("/", $class);
    if (empty($baseUrl)) {
        if ('@' == $class_strut[0] || APP_NAME == $class_strut[0]) {
            $baseUrl = dirname(LIB_PATH);
            $class = substr_replace($class, 'Lib/', 0, strlen($class_strut[0]) + 1);
        } elseif (in_array(strtolower($class_strut[0]) , array(
            'think',
            'org',
            'com'
        ))) {
            $baseUrl = THINK_PATH . '/Lib/';
        } else {
            $class = substr_replace($class, '', 0, strlen($class_strut[0]) + 1);
            $baseUrl = APP_PATH . '/../' . $class_strut[0] . '/' . LIB_DIR . '/';
        }
    }
    if (substr($baseUrl, -1) != "/") $baseUrl.= "/";
    $classfile = $baseUrl . $class . $ext;
    if ($ext == '.class.php' && is_file($classfile)) {
        $class = basename($classfile, $ext);
        if (isset($_class[$class])) throw_exception(L('_CLASS_CONFLICT_') . ':' . $_class[$class] . ' ' . $classfile);
        $_class[$class] = $classfile;
    }
    return require_cache($classfile);
}
function load($name, $baseUrl = '', $ext = '.php') {
    $name = str_replace(array(
        '.',
        '#'
    ) , array(
        '/',
        '.'
    ) , $name);
    if (empty($baseUrl)) {
        if (0 === strpos($name, '@/')) {
            $baseUrl = APP_PATH . '/Common/';
            $name = substr($name, 2);
        } else {
            $baseUrl = THINK_PATH . '/Common/';
        }
    }
    if (substr($baseUrl, -1) != "/") $baseUrl.= "/";
    require_cache($baseUrl . $name . $ext);
}
function vendor($class, $baseUrl = '', $ext = '.php') {
    if (empty($baseUrl)) $baseUrl = VENDOR_PATH;
    return import($class, $baseUrl, $ext);
}
function alias_import($alias, $classfile = '') {
    static $_alias = array();
    if ('' !== $classfile) {
        $_alias[$alias] = $classfile;
        return;
    }
    if (is_string($alias)) {
        if (isset($_alias[$alias])) return require_cache($_alias[$alias]);
    } elseif (is_array($alias)) {
        foreach ($alias as $key => $val) $_alias[$key] = $val;
        return;
    }
    return false;
}
function D($name = '', $app = '') {
    static $_model = array();
    if (empty($name)) return new Model;
    if (empty($app)) $app = C('DEFAULT_APP');
    if (isset($_model[$app . $name])) return $_model[$app . $name];
    $OriClassName = $name;
    if (strpos($name, '.')) {
        $array = explode('.', $name);
        $name = array_pop($array);
        $className = $name . 'Model';
        import($app . '.Model.' . implode('.', $array) . '.' . $className);
    } else {
        $className = $name . 'Model';
        import($app . '.Model.' . $className);
    }
    if (class_exists($className)) {
        $model = new $className();
    } else {
        $model = new Model($name);
    }
    $_model[$app . $OriClassName] = $model;
    return $model;
}
function M($name = '', $class = 'Model') {
    static $_model = array();
    if (!isset($_model[$name . '_' . $class])) $_model[$name . '_' . $class] = new $class($name);
    return $_model[$name . '_' . $class];
}
function A($name, $app = '@') {
    static $_action = array();
    if (isset($_action[$app . $name])) return $_action[$app . $name];
    $OriClassName = $name;
    if (strpos($name, '.')) {
        $array = explode('.', $name);
        $name = array_pop($array);
        $className = $name . 'Action';
        import($app . '.Action.' . implode('.', $array) . '.' . $className);
    } else {
        $className = $name . 'Action';
        import($app . '.Action.' . $className);
    }
    if (class_exists($className, false)) {
        $action = new $className();
        $_action[$app . $OriClassName] = $action;
        return $action;
    } else {
        return false;
    }
}
function R($module, $action, $app = '@') {
    $class = A($module, $app);
    if ($class) return call_user_func(array(&$class,
        $action
    ));
    else return false;
}
function L($name = null, $value = null) {
    static $_lang = array();
    if (empty($name)) return $_lang;
    if (is_string($name)) {
        $name = strtoupper($name);
        if (is_null($value)) return isset($_lang[$name]) ? $_lang[$name] : $name;
        $_lang[$name] = $value;
        return;
    }
    if (is_array($name)) $_lang = array_merge($_lang, array_change_key_case($name, CASE_UPPER));
    return;
}
function C($name = null, $value = null) {
    static $_config = array();
    if (empty($name)) return $_config;
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtolower($name);
            if (is_null($value)) return isset($_config[$name]) ? $_config[$name] : null;
            $_config[$name] = $value;
            return;
        }
        $name = explode('.', $name);
        $name[0] = strtolower($name[0]);
        if (is_null($value)) return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : null;
        $_config[$name[0]][$name[1]] = $value;
        return;
    }
    if (is_array($name)) {
        return $_config = array_merge($_config, array_change_key_case($name));
    }
    return null;
}
function tag($name, $params = array()) {
    $tags = C('TAGS.' . $name);
    if (!empty($tags)) {
        foreach ($tags as $key => $call) {
            $result = B($call, $params);
        }
    }
}
function filter($name, &$content) {
    $class = $name . 'Filter';
    require_cache(LIB_PATH . 'Filter/' . $class . '.class.php');
    $filter = new $class();
    $content = $filter->run($content);
}
function B($name, $params = array()) {
    $class = $name . 'Behavior';
    require_cache(LIB_PATH . 'Behavior/' . $class . '.class.php');
    $behavior = new $class();
    return $behavior->run($params);
}
function W($name, $data = array() , $return = false) {
    $class = $name . 'Widget';
    require_cache(LIB_PATH . 'Widget/' . $class . '.class.php');
    if (!class_exists($class)) throw_exception(L('_CLASS_NOT_EXIST_') . ':' . $class);
    $widget = Think::instance($class);
    $content = $widget->render($data);
    if ($return) return $content;
    else echo $content;
}
function S($name, $value = '', $expire = '', $type = '', $options = null) {
    static $_cache = array();
    alias_import('Cache');
    $cache = Cache::getInstance($type, $options);
    if ('' !== $value) {
        if (is_null($value)) {
            $result = $cache->rm($name);
            if ($result) unset($_cache[$type . '_' . $name]);
            return $result;
        } else {
            $cache->set($name, $value, $expire);
            $_cache[$type . '_' . $name] = $value;
        }
        return;
    }
    if (isset($_cache[$type . '_' . $name])) return $_cache[$type . '_' . $name];
    $value = $cache->get($name);
    $_cache[$type . '_' . $name] = $value;
    return $value;
}
function F($name, $value = '', $path = DATA_PATH) {
    static $_cache = array();
    $filename = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            return unlink($filename);
        } else {
            $dir = dirname($filename);
            if (!is_dir($dir)) mkdir($dir);
            $_cache[$name] = $value;
            return file_put_contents($filename, strip_whitespace("<?php\nreturn " . var_export($value, true) . ";\n?>"));
        }
    }
    if (isset($_cache[$name])) return $_cache[$name];
    if (is_file($filename)) {
        $value = include $filename;
        $_cache[$name] = $value;
    } else {
        $value = false;
    }
    return $value;
}
function to_guid_string($mix) {
    if (is_object($mix) && function_exists('spl_object_hash')) {
        return spl_object_hash($mix);
    } elseif (is_resource($mix)) {
        $mix = get_resource_type($mix) . strval($mix);
    } else {
        $mix = serialize($mix);
    }
    return md5($mix);
}
function strip_whitespace($content) {
    $stripStr = '';
    $tokens = token_get_all($content);
    $last_space = false;
    for ($i = 0, $j = count($tokens); $i < $j; $i++) {
        if (is_string($tokens[$i])) {
            $last_space = false;
            $stripStr.= $tokens[$i];
        } else {
            switch ($tokens[$i][0]) {
                case T_COMMENT:
                case T_DOC_COMMENT:
                    break;

                case T_WHITESPACE:
                    if (!$last_space) {
                        $stripStr.= ' ';
                        $last_space = true;
                    }
                    break;

                case T_START_HEREDOC:
                    $stripStr.= "<<<THINK\n";
                    break;

                case T_END_HEREDOC:
                    $stripStr.= "THINK;\n";
                    for ($k = $i + 1; $k < $j; $k++) {
                        if (is_string($tokens[$k]) && $tokens[$k] == ";") {
                            $i = $k;
                            break;
                        } else if ($tokens[$k][0] == T_CLOSE_TAG) {
                            break;
                        }
                    }
                    break;

                default:
                    $last_space = false;
                    $stripStr.= $tokens[$i][1];
                }
        }
    }
    return $stripStr;
}
function mk_dir($dir, $mode = 0777) {
    if (is_dir($dir) || @mkdir($dir, $mode)) return true;
    if (!mk_dir(dirname($dir) , $mode)) return false;
    return @mkdir($dir, $mode);
}
function auto_charset($fContents, $from = 'gbk', $to = 'utf-8') {
    $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
    $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
    if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
        return $fContents;
    }
    if (is_string($fContents)) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($fContents, $to, $from);
        } elseif (function_exists('iconv')) {
            return iconv($from, $to, $fContents);
        } else {
            return $fContents;
        }
    } elseif (is_array($fContents)) {
        foreach ($fContents as $key => $val) {
            $_key = auto_charset($key, $from, $to);
            $fContents[$_key] = auto_charset($val, $from, $to);
            if ($key != $_key) unset($fContents[$key]);
        }
        return $fContents;
    } else {
        return $fContents;
    }
}
function xml_encode($data, $encoding = 'utf-8', $root = "think") {
    $xml = '<?xml version="1.0" encoding="' . $encoding . '"?>';
    $xml.= '<' . $root . '>';
    $xml.= data_to_xml($data);
    $xml.= '</' . $root . '>';
    return $xml;
}
function data_to_xml($data) {
    if (is_object($data)) {
        $data = get_object_vars($data);
    }
    $xml = '';
    foreach ($data as $key => $val) {
        is_numeric($key) && $key = "item id=\"$key\"";
        $xml.= "<$key>";
        $xml.= (is_array($val) || is_object($val)) ? data_to_xml($val) : $val;
        list($key,) = explode(' ', $key);
        $xml.= "</$key>";
    }
    return $xml;
}
function cookie($name, $value = '', $option = null) {
    $config = array(
        'prefix' => C('COOKIE_PREFIX') ,
        'expire' => C('COOKIE_EXPIRE') ,
        'path' => C('COOKIE_PATH') ,
        'domain' => C('COOKIE_DOMAIN') ,
    );
    if (!empty($option)) {
        if (is_numeric($option)) $option = array(
            'expire' => $option
        );
        elseif (is_string($option)) parse_str($option, $option);
        $config = array_merge($config, array_change_key_case($option));
    }
    if (is_null($name)) {
        if (empty($_COOKIE)) return;
        $prefix = empty($value) ? $config['prefix'] : $value;
        if (!empty($prefix)) {
            foreach ($_COOKIE as $key => $val) {
                if (0 === stripos($key, $prefix)) {
                    setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
                    unset($_COOKIE[$key]);
                }
            }
        }
        return;
    }
    $name = $config['prefix'] . $name;
    if ('' === $value) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    } else {
        if (is_null($value)) {
            setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
            unset($_COOKIE[$name]);
        } else {
            $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
            setcookie($name, $value, $expire, $config['path'], $config['domain']);
            $_COOKIE[$name] = $value;
        }
    }
}
class Think {
    private static $_instance = array();
    public function __set($name, $value) {
        if (property_exists($this, $name)) $this->$name = $value;
    }
    public function __get($name) {
        return isset($this->$name) ? $this->$name : null;
    }
    public static function autoload($classname) {
        if (alias_import($classname)) return;
        if (substr($classname, -5) == "Model") {
            require_cache(LIB_PATH . 'Model/' . $classname . '.class.php');
        } elseif (substr($classname, -6) == "Action") {
            require_cache(LIB_PATH . 'Action/' . $classname . '.class.php');
        } else {
            if (C('APP_AUTOLOAD_PATH')) {
                $paths = explode(',', C('APP_AUTOLOAD_PATH'));
                foreach ($paths as $path) {
                    if (import($path . $classname)) return;
                }
            }
        }
        return;
    }
    static public function instance($class, $method = '') {
        $identify = $class . $method;
        if (!isset(self::$_instance[$identify])) {
            if (class_exists($class)) {
                $o = new $class();
                if (!empty($method) && method_exists($o, $method)) self::$_instance[$identify] = call_user_func_array(array(&$o,
                    $method
                ));
                else self::$_instance[$identify] = $o;
            } else halt(L('_CLASS_NOT_EXIST_') . ':' . $class);
        }
        return self::$_instance[$identify];
    }
}
class ThinkException extends Exception {
    private $type;
    private $extra;
    public function __construct($message, $code = 0, $extra = false) {
        parent::__construct($message, $code);
        $this->type = get_class($this);
        $this->extra = $extra;
    }
    public function __toString() {
        $trace = $this->getTrace();
        if ($this->extra) array_shift($trace);
        $this->class = $trace[0]['class'];
        $this->function = $trace[0]['function'];
        $this->file = $trace[0]['file'];
        $this->line = $trace[0]['line'];
        $file = file($this->file);
        $traceInfo = '';
        $time = date("y-m-d H:i:m");
        foreach ($trace as $t) {
            $traceInfo.= '[' . $time . '] ' . $t['file'] . ' (' . $t['line'] . ') ';
            $traceInfo.= $t['class'] . $t['type'] . $t['function'] . '(';
            $traceInfo.= implode(', ', $t['args']);
            $traceInfo.= ")\n";
        }
        $error['message'] = $this->message;
        $error['type'] = $this->type;
        $error['detail'] = L('_MODULE_') . '[' . MODULE_NAME . '] ' . L('_ACTION_') . '[' . ACTION_NAME . ']' . "\n";
        $error['detail'].= ($this->line - 2) . ': ' . $file[$this->line - 3];
        $error['detail'].= ($this->line - 1) . ': ' . $file[$this->line - 2];
        $error['detail'].= '<font color="#FF6600" >' . ($this->line) . ': <strong>' . $file[$this->line - 1] . '</strong></font>';
        $error['detail'].= ($this->line + 1) . ': ' . $file[$this->line];
        $error['detail'].= ($this->line + 2) . ': ' . $file[$this->line + 1];
        $error['class'] = $this->class;
        $error['function'] = $this->function;
        $error['file'] = $this->file;
        $error['line'] = $this->line;
        $error['trace'] = $traceInfo;
        if (C('LOG_EXCEPTION_RECORD')) {
            Log::Write('(' . $this->type . ') ' . $this->message);
        }
        return $error;
    }
}
class Log extends Think {
    const EMERG = 'EMERG';
    const ALERT = 'ALERT';
    const CRIT = 'CRIT';
    const ERR = 'ERR';
    const WARN = 'WARN';
    const NOTICE = 'NOTIC';
    const INFO = 'INFO';
    const DEBUG = 'DEBUG';
    const SQL = 'SQL';
    const SYSTEM = 0;
    const MAIL = 1;
    const TCP = 2;
    const FILE = 3;
    static $log = array();
    static $format = '[ c ]';
    static function record($message, $level = self::ERR, $record = false) {
        if ($record || in_array($level, C('LOG_RECORD_LEVEL'))) {
            $now = date(self::$format);
            self::$log[] = "{$now} " . $_SERVER['REQUEST_URI'] . " | {$level}: {$message}\r\n";
        }
    }
    static function save($type = self::FILE, $destination = '', $extra = '') {
        if (empty($destination)) $destination = LOG_PATH . date('y_m_d') . ".log";
        if (self::FILE == $type) {
            if (is_file($destination) && floor(C('LOG_FILE_SIZE')) <= filesize($destination)) rename($destination, dirname($destination) . '/' . time() . '-' . basename($destination));
        }
        error_log(implode("", self::$log) , $type, $destination, $extra);
        self::$log = array();
    }
    static function write($message, $level = self::ERR, $type = self::FILE, $destination = '', $extra = '') {
        $now = date(self::$format);
        if (empty($destination)) $destination = LOG_PATH . date('y_m_d') . ".log";
        if (self::FILE == $type) {
            if (is_file($destination) && floor(C('LOG_FILE_SIZE')) <= filesize($destination)) rename($destination, dirname($destination) . '/' . time() . '-' . basename($destination));
        }
        error_log("{$now} " . $_SERVER['REQUEST_URI'] . " | {$level}: {$message}\r\n", $type, $destination, $extra);
    }
}
class Dispatcher extends Think {
    static public function dispatch() {
        $urlMode = C('URL_MODEL');
        if ($urlMode == URL_REWRITE) {
            $url = dirname(_PHP_FILE_);
            if ($url == '/' || $url == '\\') $url = '';
            define('PHP_FILE', $url);
        } elseif ($urlMode == URL_COMPAT) {
            define('PHP_FILE', _PHP_FILE_ . '?' . C('VAR_PATHINFO') . '=');
        } else {
            define('PHP_FILE', _PHP_FILE_);
        }
        if (C('APP_SUB_DOMAIN_DEPLOY')) {
            $rules = C('APP_SUB_DOMAIN_RULES');
            $subDomain = strtolower(substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.')));
            define('SUB_DOMAIN', $subDomain);
            if ($subDomain && array_key_exists($subDomain, $rules)) {
                $rule = $rules[$subDomain];
            } elseif (isset($rules['*'])) {
                if ('www' != $subDomain && !in_array($subDomain, C('APP_SUB_DOMAIN_DENY'))) {
                    $rule = $rules['*'];
                }
            }
            if (!empty($rule)) {
                $array = explode('/', $rule[0]);
                $module = array_pop($array);
                if (!empty($module)) {
                    $_GET[C('VAR_MODULE') ] = $module;
                    $domainModule = true;
                }
                if (!empty($array)) {
                    $_GET[C('VAR_GROUP') ] = array_pop($array);
                    $domainGroup = true;
                }
                if (isset($rule[1])) {
                    parse_str($rule[1], $parms);
                    $_GET = array_merge($_GET, $parms);
                }
            }
        }
        $depr = C('URL_PATHINFO_DEPR');
        self::getPathInfo();
        if (!self::routerCheck()) {
            $paths = explode($depr, trim($_SERVER['PATH_INFO'], '/'));
            $var = array();
            if (C('APP_GROUP_LIST') && !isset($_GET[C('VAR_GROUP') ])) {
                $var[C('VAR_GROUP') ] = in_array(strtolower($paths[0]) , explode(',', strtolower(C('APP_GROUP_LIST')))) ? array_shift($paths) : '';
                if (C('APP_GROUP_DENY') && in_array(strtolower($var[C('VAR_GROUP') ]) , explode(',', strtolower(C('APP_GROUP_DENY'))))) {
                    exit;
                }
            }
            if (!isset($_GET[C('VAR_MODULE') ])) {
                $var[C('VAR_MODULE') ] = array_shift($paths);
            }
            $var[C('VAR_ACTION') ] = array_shift($paths);
            $res = preg_replace('@(\w+)' . $depr . '([^' . $depr . '\/]+)@e', '$var[\'\\1\']=strip_tags(\'\\2\');', implode($depr, $paths));
            $_GET = array_merge($var, $_GET);
        }
        if (C('APP_GROUP_LIST')) {
            define('GROUP_NAME', self::getGroup(C('VAR_GROUP')));
            if (is_file(CONFIG_PATH . GROUP_NAME . '/config.php')) C(include CONFIG_PATH . GROUP_NAME . '/config.php');
            if (is_file(COMMON_PATH . GROUP_NAME . '/function.php')) include COMMON_PATH . GROUP_NAME . '/function.php';
        }
        define('MODULE_NAME', self::getModule(C('VAR_MODULE')));
        define('ACTION_NAME', self::getAction(C('VAR_ACTION')));
        define('__SELF__', strip_tags($_SERVER['REQUEST_URI']));
        define('__INFO__', $_SERVER['PATH_INFO']);
        define('__APP__', strip_tags(PHP_FILE));
        $module = defined('P_MODULE_NAME') ? P_MODULE_NAME : MODULE_NAME;
        if (defined('GROUP_NAME')) {
            $group = C('URL_CASE_INSENSITIVE') ? strtolower(GROUP_NAME) : GROUP_NAME;
            define('__GROUP__', (!empty($domainGroup) || GROUP_NAME == C('DEFAULT_GROUP')) ? __APP__ : __APP__ . '/' . $group);
            define('__URL__', !empty($domainModule) ? __GROUP__ . $depr : __GROUP__ . $depr . $module);
        } else {
            define('__URL__', !empty($domainModule) ? __APP__ . '/' : __APP__ . '/' . $module);
        }
        define('__ACTION__', __URL__ . $depr . ACTION_NAME);
        $_REQUEST = array_merge($_POST, $_GET);
    }
    public static function getPathInfo() {
        if (!empty($_GET[C('VAR_PATHINFO') ])) {
            $path = $_GET[C('VAR_PATHINFO') ];
            unset($_GET[C('VAR_PATHINFO') ]);
        } elseif (!empty($_SERVER['PATH_INFO'])) {
            $pathInfo = $_SERVER['PATH_INFO'];
            if (0 === strpos($pathInfo, $_SERVER['SCRIPT_NAME'])) $path = substr($pathInfo, strlen($_SERVER['SCRIPT_NAME']));
            else $path = $pathInfo;
        } elseif (!empty($_SERVER['ORIG_PATH_INFO'])) {
            $pathInfo = $_SERVER['ORIG_PATH_INFO'];
            if (0 === strpos($pathInfo, $_SERVER['SCRIPT_NAME'])) $path = substr($pathInfo, strlen($_SERVER['SCRIPT_NAME']));
            else $path = $pathInfo;
        } elseif (!empty($_SERVER['REDIRECT_PATH_INFO'])) {
            $path = $_SERVER['REDIRECT_PATH_INFO'];
        } elseif (!empty($_SERVER["REDIRECT_URL"])) {
            $path = $_SERVER["REDIRECT_URL"];
            if (empty($_SERVER['QUERY_STRING']) || $_SERVER['QUERY_STRING'] == $_SERVER["REDIRECT_QUERY_STRING"]) {
                $parsedUrl = parse_url($_SERVER["REQUEST_URI"]);
                if (!empty($parsedUrl['query'])) {
                    $_SERVER['QUERY_STRING'] = $parsedUrl['query'];
                    parse_str($parsedUrl['query'], $GET);
                    $_GET = array_merge($_GET, $GET);
                    reset($_GET);
                } else {
                    unset($_SERVER['QUERY_STRING']);
                }
                reset($_SERVER);
            }
        }
        if (C('URL_HTML_SUFFIX') && !empty($path)) {
            $path = preg_replace('/\.' . trim(C('URL_HTML_SUFFIX') , '.') . '$/', '', $path);
        }
        $_SERVER['PATH_INFO'] = empty($path) ? '/' : $path;
    }
    static public function routerCheck() {
        $regx = trim($_SERVER['PATH_INFO'], '/');
        if (empty($regx)) return true;
        if (!C('URL_ROUTER_ON')) return false;
        $routes = C('URL_ROUTE_RULES');
        if (is_array(C('routes'))) $routes = C('routes');
        if (!empty($routes)) {
            $depr = C('URL_PATHINFO_DEPR');
            foreach ($routes as $key => $route) {
                if (0 === stripos($regx . $depr, $route[0] . $depr)) {
                    $var = self::parseUrl($route[1]);
                    $paths = explode($depr, trim(str_ireplace($route[0] . $depr, $depr, $regx) , $depr));
                    $vars = explode(',', $route[2]);
                    for ($i = 0; $i < count($vars); $i++) $var[$vars[$i]] = array_shift($paths);
                    $res = preg_replace('@(\w+)\/([^,\/]+)@e', '$var[\'\\1\']=strip_tags(\'\\2\');', implode('/', $paths));
                    $_GET = array_merge($var, $_GET);
                    if (isset($route[3])) {
                        parse_str($route[3], $params);
                        $_GET = array_merge($_GET, $params);
                    }
                    return true;
                } elseif (1 < substr_count($route[0], '/') && preg_match($route[0], $regx, $matches)) {
                    $var = self::parseUrl($route[1]);
                    $vars = explode(',', $route[2]);
                    for ($i = 0; $i < count($vars); $i++) $var[$vars[$i]] = $matches[$i + 1];
                    $res = preg_replace('@(\w+)\/([^,\/]+)@e', '$var[\'\\1\']=strip_tags(\'\\2\');', str_replace($matches[0], '', $regx));
                    $_GET = array_merge($var, $_GET);
                    if (isset($route[3])) {
                        parse_str($route[3], $params);
                        $_GET = array_merge($_GET, $params);
                    }
                    return true;
                }
            }
        }
        return false;
    }
    static private function parseUrl($route) {
        $array = explode('/', $route);
        $var = array();
        $var[C('VAR_ACTION') ] = array_pop($array);
        $var[C('VAR_MODULE') ] = array_pop($array);
        if (!empty($array)) $var[C('VAR_GROUP') ] = array_pop($array);
        return $var;
    }
    static private function getModule($var) {
        $module = (!empty($_GET[$var]) ? $_GET[$var] : C('DEFAULT_MODULE'));
        if (C('URL_CASE_INSENSITIVE')) {
            define('P_MODULE_NAME', strtolower($module));
            $module = ucfirst(parse_name(P_MODULE_NAME, 1));
        }
        unset($_GET[$var]);
        return strip_tags($module);
    }
    static private function getAction($var) {
        $action = !empty($_POST[$var]) ? $_POST[$var] : (!empty($_GET[$var]) ? $_GET[$var] : C('DEFAULT_ACTION'));
        unset($_POST[$var], $_GET[$var]);
        define('P_ACTION_NAME', $action);
        return strip_tags(C('URL_CASE_INSENSITIVE') ? strtolower($action) : $action);
    }
    static private function getGroup($var) {
        $group = (!empty($_GET[$var]) ? $_GET[$var] : C('DEFAULT_GROUP'));
        unset($_GET[$var]);
        return strip_tags(ucfirst(strtolower($group)));
    }
}
class App {
    static public function init() {
        set_error_handler(array(
            'App',
            'appError'
        ));
        set_exception_handler(array(
            'App',
            'appException'
        ));
        if (function_exists('spl_autoload_register')) spl_autoload_register(array(
            'Think',
            'autoload'
        ));
        if (function_exists('date_default_timezone_set')) date_default_timezone_set(C('DEFAULT_TIMEZONE'));
        if (is_file(COMMON_PATH . 'extend.php')) include COMMON_PATH . 'extend.php';
        Dispatcher::dispatch();
        if (is_file(CONFIG_PATH . strtolower(MODULE_NAME) . '_config.php')) C(include CONFIG_PATH . strtolower(MODULE_NAME) . '_config.php');
        App::checkLanguage();
        App::checkTemplate();
        if (C('HTML_CACHE_ON')) HtmlCache::readHTMLCache();
        return;
    }
    static private function checkLanguage() {
        $langSet = C('DEFAULT_LANG');
        if (!C('LANG_SWITCH_ON')) {
            L(include THINK_PATH . '/Lang/' . $langSet . '.php');
            return;
        }
        if (C('LANG_AUTO_DETECT')) {
            if (isset($_GET[C('VAR_LANGUAGE') ])) {
                $langSet = $_GET[C('VAR_LANGUAGE') ];
                cookie('think_language', $langSet, 3600);
            } elseif (cookie('think_language')) {
                $langSet = cookie('think_language');
            } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
                $langSet = $matches[1];
                cookie('think_language', $langSet, 3600);
            }
        }
        define('LANG_SET', strtolower($langSet));
        if (is_file(THINK_PATH . '/Lang/' . LANG_SET . '.php')) L(include THINK_PATH . '/Lang/' . LANG_SET . '.php');
        if (is_file(LANG_PATH . LANG_SET . '/common.php')) L(include LANG_PATH . LANG_SET . '/common.php');
        $group = '';
        if (defined('GROUP_NAME')) {
            $group = GROUP_NAME . C('TMPL_FILE_DEPR');
            if (is_file(LANG_PATH . LANG_SET . '/' . $group . 'lang.php')) L(include LANG_PATH . LANG_SET . '/' . $group . 'lang.php');
        }
        if (is_file(LANG_PATH . LANG_SET . '/' . $group . strtolower(MODULE_NAME) . '.php')) L(include LANG_PATH . LANG_SET . '/' . $group . strtolower(MODULE_NAME) . '.php');
    }
    static private function checkTemplate() {
        $templateSet = C('DEFAULT_THEME');
        if (C('TMPL_DETECT_THEME')) {
            $t = C('VAR_TEMPLATE');
            if (isset($_GET[$t])) {
                $templateSet = $_GET[$t];
            } elseif (cookie('think_template')) {
                $templateSet = cookie('think_template');
            }
            if (!is_dir(TMPL_PATH . $templateSet)) $templateSet = C('DEFAULT_THEME');
            cookie('think_template', $templateSet);
        }
        define('TEMPLATE_NAME', $templateSet);
        define('APP_TMPL_PATH', __ROOT__ . '/' . (APP_NAME ? APP_NAME . '/' : '') . TMPL_DIR . '/' . (TEMPLATE_NAME ? TEMPLATE_NAME . '/' : ''));
        define('TEMPLATE_PATH', TMPL_PATH . (TEMPLATE_NAME ? TEMPLATE_NAME . '/' : ''));
        define('__CURRENT__', APP_TMPL_PATH . MODULE_NAME);
        define('WEB_PUBLIC_PATH', __ROOT__ . '/Public');
        define('APP_PUBLIC_PATH', APP_TMPL_PATH . 'Public');
        if (defined('GROUP_NAME')) {
            C('TMPL_FILE_NAME', TEMPLATE_PATH . GROUP_NAME . '/' . MODULE_NAME . C('TMPL_FILE_DEPR') . ACTION_NAME . C('TMPL_TEMPLATE_SUFFIX'));
            C('CACHE_PATH', CACHE_PATH . GROUP_NAME . '/');
        } else {
            C('TMPL_FILE_NAME', TEMPLATE_PATH . MODULE_NAME . '/' . ACTION_NAME . C('TMPL_TEMPLATE_SUFFIX'));
            C('CACHE_PATH', CACHE_PATH);
        }
        return;
    }
    static public function exec() {
        if (!preg_match('/^[A-Za-z_0-9]+$/', MODULE_NAME)) {
            throw_exception(L('_MODULE_NOT_EXIST_'));
        }
        $group = defined('GROUP_NAME') ? GROUP_NAME . C('APP_GROUP_DEPR') : '';
        $module = A($group . MODULE_NAME);
        if (!$module) {
            $_module = C('modules.' . MODULE_NAME);
            if ($_module) {
                import($_module[0]);
                $class = isset($_module[1]) ? $_module[1] : MODULE_NAME . 'Action';
                $module = new $class;
            } else {
                $module = A("Empty");
            }
            if (!$module) {
                if (C('APP_DEBUG')) {
                    throw_exception(L('_MODULE_NOT_EXIST_') . MODULE_NAME);
                } else {
                    header('HTTP/1.1 404 Not Found');
                    header('Status:404 Not Found');
                    exit;
                }
            }
        }
        $action = ACTION_NAME;
        if (method_exists($module, '_before_' . $action)) {
            call_user_func(array(&$module,
                '_before_' . $action
            ));
        }
        call_user_func(array(&$module,
            $action
        ));
        if (method_exists($module, '_after_' . $action)) {
            call_user_func(array(&$module,
                '_after_' . $action
            ));
        }
        return;
    }
    static public function run() {
        App::init();
        $plugin = C('APP_PLUGIN_ON');
        if ($plugin) tag('app_begin');
        if (isset($_REQUEST[C("VAR_SESSION_ID") ])) session_id($_REQUEST[C("VAR_SESSION_ID") ]);
        if (C('SESSION_AUTO_START')) session_start();
        if (C('SHOW_RUN_TIME')) G('initTime');
        App::exec();
        if ($plugin) tag('app_end');
        if (C('LOG_RECORD')) Log::save();
        return;
    }
    static public function appException($e) {
        halt($e->__toString());
    }
    static public function appError($errno, $errstr, $errfile, $errline) {
        switch ($errno) {
            case E_ERROR:
            case E_USER_ERROR:
                $errorStr = "[$errno] $errstr " . basename($errfile) . " 第 $errline 行.";
                if (C('LOG_RECORD')) Log::write($errorStr, Log::ERR);
                halt($errorStr);
                break;

            case E_STRICT:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            default:
                $errorStr = "[$errno] $errstr " . basename($errfile) . " 第 $errline 行.";
                Log::record($errorStr, Log::NOTICE);
                break;
            }
    }
};
abstract class Action extends Think {
    protected $view = null;
    private $name = '';
    public function __construct() {
        $this->view = Think::instance('View');
        if (method_exists($this, '_initialize')) $this->_initialize();
    }
    protected function getActionName() {
        if (empty($this->name)) {
            $this->name = substr(get_class($this) , 0, -6);
        }
        return $this->name;
    }
    protected function isAjax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if ('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) return true;
        }
        if (!empty($_POST[C('VAR_AJAX_SUBMIT') ]) || !empty($_GET[C('VAR_AJAX_SUBMIT') ])) return true;
        return false;
    }
    protected function display($templateFile = '', $charset = '', $contentType = '') {
        if (false === $templateFile) {
            $this->showTrace();
        } else {
            $this->view->display($templateFile, $charset, $contentType);
        }
    }
    protected function fetch($templateFile = '', $charset = '', $contentType = '') {
        return $this->view->fetch($templateFile, $charset, $contentType);
    }
    protected function buildHtml($htmlfile = '', $htmlpath = '', $templateFile = '', $charset = '', $contentType = '') {
        return $this->view->buildHtml($htmlfile, $htmlpath, $templateFile, $charset, $contentType);
    }
    protected function assign($name, $value = '') {
        $this->view->assign($name, $value);
    }
    public function __set($name, $value) {
        $this->view->assign($name, $value);
    }
    public function __get($name) {
        return $this->view->get($name);
    }
    protected function trace($name, $value = '') {
        $this->view->trace($name, $value);
    }
    public function __call($method, $args) {
        if (0 === strcasecmp($method, ACTION_NAME)) {
            $_action = C('actions');
            if ($_action) {
                if (isset($_action[MODULE_NAME . ':' . ACTION_NAME])) {
                    $action = $_action[MODULE_NAME . ':' . ACTION_NAME];
                } elseif (isset($_action[ACTION_NAME])) {
                    $action = $_action[ACTION_NAME];
                }
                if (!empty($action)) {
                    call_user_func($action);
                    return;
                }
            }
            if (method_exists($this, '_empty')) {
                $this->_empty($method, $args);
            } elseif (file_exists_case(C('TMPL_FILE_NAME'))) {
                $this->display();
            } elseif (C('APP_DEBUG')) {
                throw_exception(L('_ERROR_ACTION_') . ACTION_NAME);
            } else {
                header('HTTP/1.1 404 Not Found');
                header('Status:404 Not Found');
                exit;
            }
        } else {
            switch (strtolower($method)) {
                case 'ispost':
                case 'isget':
                case 'ishead':
                case 'isdelete':
                case 'isput':
                    return strtolower($_SERVER['REQUEST_METHOD']) == strtolower(substr($method, 2));
                default:
                    throw_exception(__CLASS__ . ':' . $method . L('_METHOD_NOT_EXIST_'));
            }
        }
    }
    protected function error($message, $ajax = false) {
        $this->_dispatch_jump($message, 0, $ajax);
    }
    protected function success($message, $ajax = false) {
        $this->_dispatch_jump($message, 1, $ajax);
    }
    protected function ajaxReturn($data, $info = '', $status = 1, $type = '') {
        $result = array();
        $result['status'] = $status;
        $result['info'] = $info;
        $result['data'] = $data;
        if (method_exists($this, "ajaxAssign")) $this->ajaxAssign($result);
        if (empty($type)) $type = C('DEFAULT_AJAX_RETURN');
        if (strtoupper($type) == 'JSON') {
            header("Content-Type:text/html; charset=utf-8");
            exit(json_encode($result));
        } elseif (strtoupper($type) == 'XML') {
            header("Content-Type:text/xml; charset=utf-8");
            exit(xml_encode($result));
        } elseif (strtoupper($type) == 'EVAL') {
            header("Content-Type:text/html; charset=utf-8");
            exit($data);
        } else {
        }
    }
    protected function redirect($url, $params = array() , $delay = 0, $msg = '') {
        $url = U($url, $params);
        redirect($url, $delay, $msg);
    }
    private function _dispatch_jump($message, $status = 1, $ajax = false) {
        if ($ajax || $this->isAjax()) $this->ajaxReturn($ajax, $message, $status);
        if (!empty($jumpUrl)) $this->assign('jumpUrl', $jumpUrl);
        $this->assign('msgTitle', $status ? L('_OPERATION_SUCCESS_') : L('_OPERATION_FAIL_'));
        if ($this->view->get('closeWin')) $this->assign('jumpUrl', 'javascript:window.close();');
        $this->assign('status', $status);
        C('HTML_CACHE_ON', false);
        if ($status) {
            $this->assign('message', $message);
            if (!$this->view->get('waitSecond')) $this->assign('waitSecond', "1");
            if (!$this->view->get('jumpUrl')) $this->assign("jumpUrl", $_SERVER["HTTP_REFERER"]);
            $this->display(C('TMPL_ACTION_SUCCESS'));
        } else {
            $this->assign('error', $message);
            if (!$this->view->get('waitSecond')) $this->assign('waitSecond', "3");
            if (!$this->view->get('jumpUrl')) $this->assign('jumpUrl', "javascript:history.back(-1);");
            $this->display(C('TMPL_ACTION_ERROR'));
            exit;
        }
    }
    protected function showTrace() {
        $this->view->traceVar();
    }
    public function __destruct() {
        if (C('LOG_RECORD')) Log::save();
    }
}
class View extends Think {
    protected $tVar = array();
    protected $trace = array();
    protected $templateFile = '';
    public function assign($name, $value = '') {
        if (is_array($name)) {
            $this->tVar = array_merge($this->tVar, $name);
        } elseif (is_object($name)) {
            foreach ($name as $key => $val) $this->tVar[$key] = $val;
        } else {
            $this->tVar[$name] = $value;
        }
    }
    public function trace($title, $value = '') {
        if (is_array($title)) $this->trace = array_merge($this->trace, $title);
        else $this->trace[$title] = $value;
    }
    public function get($name) {
        if (isset($this->tVar[$name])) return $this->tVar[$name];
        else return false;
    }
    public function getAllVar() {
        return $this->tVar;
    }
    public function traceVar() {
        foreach ($this->tVar as $name => $val) {
            dump($val, 1, '[' . $name . ']<br/>');
        }
    }
    public function display($templateFile = '', $charset = '', $contentType = '') {
        $this->fetch($templateFile, $charset, $contentType, true);
    }
    protected function layout($content, $charset = '', $contentType = '') {
        if (false !== strpos($content, '<!-- layout')) {
            $find = preg_match_all('/<!-- layout::(.+?)::(.+?) -->/is', $content, $matches);
            if ($find) {
                for ($i = 0; $i < $find; $i++) {
                    if (0 === strpos($matches[1][$i], '$')) $matches[1][$i] = $this->get(substr($matches[1][$i], 1));
                    if (0 != $matches[2][$i]) {
                        $guid = md5($matches[1][$i]);
                        $cache = S($guid);
                        if ($cache) {
                            $layoutContent = $cache;
                        } else {
                            $layoutContent = $this->fetch($matches[1][$i], $charset, $contentType);
                            S($guid, $layoutContent, $matches[2][$i]);
                        }
                    } else {
                        $layoutContent = $this->fetch($matches[1][$i], $charset, $contentType);
                    }
                    $content = str_replace($matches[0][$i], $layoutContent, $content);
                }
            }
        }
        return $content;
    }
    public function fetch($templateFile = '', $charset = '', $contentType = '', $display = false) {
        G('viewStartTime');
        if (null === $templateFile) return;
        if (empty($charset)) $charset = C('DEFAULT_CHARSET');
        if (empty($contentType)) $contentType = C('TMPL_CONTENT_TYPE');
        header('Content-Type:' . $contentType . '; charset=' . $charset);
        header('Cache-control: private');
        header('X-Powered-By:ThinkPHP');
        ob_start();
        ob_implicit_flush(0);
        if (!file_exists_case($templateFile)) $templateFile = $this->parseTemplateFile($templateFile);
        $engine = strtolower(C('TMPL_ENGINE_TYPE'));
        if ('php' == $engine) {
            extract($this->tVar, EXTR_OVERWRITE);
            include $templateFile;
        } elseif ('think' == $engine && $this->checkCache($templateFile)) {
            extract($this->tVar, EXTR_OVERWRITE);
            include C('CACHE_PATH') . md5($templateFile) . C('TMPL_CACHFILE_SUFFIX');
        } else {
            $className = 'Template' . ucwords($engine);
            require_cache(THINK_PATH . '/Lib/Think/Util/Template/' . $className . '.class.php');
            $tpl = new $className;
            $tpl->fetch($templateFile, $this->tVar, $charset);
        }
        $this->templateFile = $templateFile;
        $content = ob_get_clean();
        $content = $this->templateContentReplace($content);
        $content = $this->layout($content, $charset, $contentType);
        return $this->output($content, $display);
    }
    protected function checkCache($tmplTemplateFile) {
        if (!C('TMPL_CACHE_ON')) return false;
        $tmplCacheFile = C('CACHE_PATH') . md5($tmplTemplateFile) . C('TMPL_CACHFILE_SUFFIX');
        if (!is_file($tmplCacheFile)) {
            return false;
        } elseif (filemtime($tmplTemplateFile) > filemtime($tmplCacheFile)) {
            return false;
        } elseif (C('TMPL_CACHE_TIME') != 0 && time() > filemtime($tmplCacheFile) + C('TMPL_CACHE_TIME')) {
            return false;
        }
        return true;
    }
    public function buildHtml($htmlfile, $htmlpath = '', $templateFile = '', $charset = '', $contentType = '') {
        $content = $this->fetch($templateFile, $charset, $contentType);
        $htmlpath = !empty($htmlpath) ? $htmlpath : HTML_PATH;
        $htmlfile = $htmlpath . $htmlfile . C('HTML_FILE_SUFFIX');
        if (!is_dir(dirname($htmlfile))) mk_dir(dirname($htmlfile));
        if (false === file_put_contents($htmlfile, $content)) throw_exception(L('_CACHE_WRITE_ERROR_') . ':' . $htmlfile);
        return $content;
    }
    protected function output($content, $display) {
        if (C('HTML_CACHE_ON')) HtmlCache::writeHTMLCache($content);
        if ($display) {
            if (C('SHOW_RUN_TIME')) {
                if (false !== strpos($content, '{__NORUNTIME__}')) {
                    $content = str_replace('{__NORUNTIME__}', '', $content);
                } else {
                    $runtime = $this->showTime();
                    if (strpos($content, '{__RUNTIME__}')) $content = str_replace('{__RUNTIME__}', $runtime, $content);
                    else $content.= $runtime;
                }
            } else {
                $content = str_replace(array(
                    '{__NORUNTIME__}',
                    '{__RUNTIME__}'
                ) , '', $content);
            }
            echo $content;
            if (C('SHOW_PAGE_TRACE')) $this->showTrace();
            return null;
        } else {
            return $content;
        }
    }
    protected function templateContentReplace($content) {
        $replace = array(
            '../Public' => APP_PUBLIC_PATH,
            '__PUBLIC__' => WEB_PUBLIC_PATH,
            '__TMPL__' => APP_TMPL_PATH,
            '__ROOT__' => __ROOT__,
            '__APP__' => __APP__,
            '__GROUP__' => defined('GROUP_NAME') ? __GROUP__ : __APP__,
            '__UPLOAD__' => __ROOT__ . '/Uploads',
            '__ACTION__' => __ACTION__,
            '__SELF__' => __SELF__,
            '__URL__' => __URL__,
            '__INFO__' => __INFO__,
        );
        if (C('TOKEN_ON')) {
            if (strpos($content, '{__TOKEN__}')) {
                $replace['{__TOKEN__}'] = $this->buildFormToken();
            } elseif (strpos($content, '{__NOTOKEN__}')) {
                $replace['{__NOTOKEN__}'] = $this->buildFormToken();
            } elseif (preg_match('/<\/form(\s*)>/is', $content, $match)) {
                $replace[$match[0]] = $this->buildFormToken() . $match[0];
            }
        }
        if (is_array(C('TMPL_PARSE_STRING'))) $replace = array_merge($replace, C('TMPL_PARSE_STRING'));
        $content = str_replace(array_keys($replace) , array_values($replace) , $content);
        return $content;
    }
    private function buildFormToken() {
        $tokenName = C('TOKEN_NAME');
        $tokenType = C('TOKEN_TYPE');
        if (!isset($_SESSION[$tokenName])) {
            $_SESSION[$tokenName] = array();
        }
        $tokenKey = md5(__SELF__);
        if (isset($_SESSION[$tokenName][$tokenKey])) {
            $tokenValue = $_SESSION[$tokenName][$tokenKey];
        } else {
            $tokenValue = $tokenType(microtime(TRUE));
            $_SESSION[$tokenName][$tokenKey] = $tokenValue;
        }
        $token = '<input type="hidden" name="' . $tokenName . '" value="' . $tokenKey . '_' . $tokenValue . '" />';
        return $token;
    }
    private function parseTemplateFile($templateFile) {
        if ('' == $templateFile) {
            $templateFile = C('TMPL_FILE_NAME');
        } elseif (false === strpos($templateFile, '.')) {
            $templateFile = str_replace(array(
                '@',
                ':'
            ) , '/', $templateFile);
            $count = substr_count($templateFile, '/');
            $path = dirname(C('TMPL_FILE_NAME'));
            for ($i = 0; $i < $count; $i++) $path = dirname($path);
            $templateFile = $path . '/' . $templateFile . C('TMPL_TEMPLATE_SUFFIX');
        }
        if (!file_exists_case($templateFile)) throw_exception(L('_TEMPLATE_NOT_EXIST_') . '[' . $templateFile . ']');
        return $templateFile;
    }
    private function showTime() {
        G('viewEndTime');
        $showTime = 'Process: ' . G('beginTime', 'viewEndTime') . 's ';
        if (C('SHOW_ADV_TIME')) {
            $showTime.= '( Load:' . G('beginTime', 'loadTime') . 's Init:' . G('loadTime', 'initTime') . 's Exec:' . G('initTime', 'viewStartTime') . 's Template:' . G('viewStartTime', 'viewEndTime') . 's )';
        }
        if (C('SHOW_DB_TIMES') && class_exists('Db', false)) {
            $showTime.= ' | DB :' . N('db_query') . ' queries ' . N('db_write') . ' writes ';
        }
        if (C('SHOW_CACHE_TIMES') && class_exists('Cache', false)) {
            $showTime.= ' | Cache :' . N('cache_read') . ' gets ' . N('cache_write') . ' writes ';
        }
        if (MEMORY_LIMIT_ON && C('SHOW_USE_MEM')) {
            $showTime.= ' | UseMem:' . number_format((memory_get_usage() - $GLOBALS['_startUseMems']) / 1024) . ' kb';
        }
        return $showTime;
    }
    private function showTrace() {
        $traceFile = CONFIG_PATH . 'trace.php';
        $_trace = is_file($traceFile) ? include $traceFile : array();
        $this->trace('当前页面', __SELF__);
        $this->trace('模板缓存', C('CACHE_PATH') . md5($this->templateFile) . C('TMPL_CACHFILE_SUFFIX'));
        $this->trace('请求方法', $_SERVER['REQUEST_METHOD']);
        $this->trace('通信协议', $_SERVER['SERVER_PROTOCOL']);
        $this->trace('请求时间', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']));
        $this->trace('用户代理', $_SERVER['HTTP_USER_AGENT']);
        $this->trace('会话ID', session_id());
        $log = Log::$log;
        $this->trace('日志记录', count($log) ? count($log) . '条日志<br/>' . implode('<br/>', $log) : '无日志记录');
        $files = get_included_files();
        $this->trace('加载文件', count($files) . str_replace("\n", '<br/>', substr(substr(print_r($files, true) , 7) , 0, -2)));
        $_trace = array_merge($_trace, $this->trace);
        include C('TMPL_TRACE_FILE');
    }
}
alias_import(array(
    'Model' => THINK_PATH . '/Lib/Think/Core/Model.class.php',
    'Dispatcher' => THINK_PATH . '/Lib/Think/Util/Dispatcher.class.php',
    'HtmlCache' => THINK_PATH . '/Lib/Think/Util/HtmlCache.class.php',
    'Db' => THINK_PATH . '/Lib/Think/Db/Db.class.php',
    'ThinkTemplate' => THINK_PATH . '/Lib/Think/Template/ThinkTemplate.class.php',
    'Template' => THINK_PATH . '/Lib/Think/Util/Template.class.php',
    'TagLib' => THINK_PATH . '/Lib/Think/Template/TagLib.class.php',
    'Cache' => THINK_PATH . '/Lib/Think/Util/Cache.class.php',
    'Debug' => THINK_PATH . '/Lib/Think/Util/Debug.class.php',
    'Session' => THINK_PATH . '/Lib/Think/Util/Session.class.php',
    'TagLibCx' => THINK_PATH . '/Lib/Think/Template/TagLib/TagLibCx.class.php',
    'TagLibHtml' => THINK_PATH . '/Lib/Think/Template/TagLib/TagLibHtml.class.php',
    'ViewModel' => THINK_PATH . '/Lib/Think/Core/Model/ViewModel.class.php',
    'AdvModel' => THINK_PATH . '/Lib/Think/Core/Model/AdvModel.class.php',
    'RelationModel' => THINK_PATH . '/Lib/Think/Core/Model/RelationModel.class.php',
));
C(array(
    'app_debug' => false,
    'app_sub_domain_deploy' => false,
    'app_plugin_on' => false,
    'app_file_case' => false,
    'app_group_depr' => '.',
    'app_group_list' => '',
    'app_autoload_path' => 'Think.Util.',
    'app_config_list' => '',
    'cookie_expire' => 3600,
    'cookie_domain' => '',
    'cookie_path' => '/',
    'cookie_prefix' => '',
    'default_app' => '@',
    'default_group' => 'Home',
    'default_module' => 'Index',
    'default_action' => 'index',
    'default_charset' => 'utf-8',
    'default_timezone' => 'PRC',
    'default_ajax_return' => 'JSON',
    'default_theme' => 'default',
    'default_lang' => 'zh-cn',
    'db_type' => 'mysql',
    'db_host' => 'localhost',
    'db_name' => '',
    'db_user' => 'root',
    'db_pwd' => '',
    'db_port' => '',
    'db_prefix' => 'think_',
    'db_suffix' => '',
    'db_fieldtype_check' => false,
    'db_fields_cache' => true,
    'db_charset' => 'utf8',
    'db_deploy_type' => 0,
    'db_rw_separate' => false,
    'data_cache_time' => 0,
    'data_cache_compress' => false,
    'data_cache_check' => false,
    'data_cache_type' => 'File',
    'data_cache_path' => './Runtime/Temp/',
    'data_cache_subdir' => false,
    'data_path_level' => 1,
    'error_message' => '您浏览的页面暂时发生了错误！请稍后再试～',
    'error_page' => '',
    'html_cache_on' => false,
    'html_cache_time' => 60,
    'html_read_type' => 0,
    'html_file_suffix' => '.shtml',
    'lang_switch_on' => false,
    'lang_auto_detect' => true,
    'log_exception_record' => true,
    'log_record' => false,
    'log_file_size' => 2097152,
    'log_record_level' => array(
        0 => 'EMERG',
        1 => 'ALERT',
        2 => 'CRIT',
        3 => 'ERR',
    ) ,
    'session_auto_start' => true,
    'var_session_id' => 'session_id',
    'show_run_time' => false,
    'show_adv_time' => false,
    'show_db_times' => false,
    'show_cache_times' => false,
    'show_use_mem' => false,
    'show_page_trace' => false,
    'show_error_msg' => false,
    'tmpl_engine_type' => 'Think',
    'tmpl_detect_theme' => false,
    'tmpl_template_suffix' => '.html',
    'tmpl_content_type' => 'text/html',
    'tmpl_cachfile_suffix' => '.php',
    'tmpl_deny_func_list' => 'echo,exit',
    'tmpl_deny_php' => false,
    'tmpl_parse_string' => '',
    'tmpl_l_delim' => '{',
    'tmpl_r_delim' => '}',
    'tmpl_var_identify' => 'array',
    'tmpl_strip_space' => true,
    'tmpl_cache_on' => true,
    'tmpl_cache_time' => 0,
    'tmpl_action_error' => './ThinkPHP/Tpl/dispatch_jump.html',
    'tmpl_action_success' => './ThinkPHP/Tpl/dispatch_jump.html',
    'tmpl_trace_file' => './ThinkPHP/Tpl/PageTrace.tpl.php',
    'tmpl_exception_file' => './ThinkPHP/Tpl/ThinkException.tpl.php',
    'tmpl_file_depr' => '/',
    'taglib_begin' => '<',
    'taglib_end' => '>',
    'taglib_load' => true,
    'taglib_build_in' => 'cx',
    'taglib_pre_load' => '',
    'tag_nested_level' => 3,
    'token_on' => true,
    'token_name' => '__hash__',
    'token_type' => 'md5',
    'token_reset' => true,
    'page_rollpage' => 5,
    'page_listrows' => 20,
    'url_case_insensitive' => false,
    'url_router_on' => false,
    'url_route_rules' => array() ,
    'url_model' => 1,
    'url_pathinfo_depr' => '/',
    'url_html_suffix' => '',
    'var_group' => 'g',
    'var_module' => 'm',
    'var_action' => 'a',
    'var_page' => 'p',
    'var_template' => 't',
    'var_language' => 'l',
    'var_ajax_submit' => 'ajax',
    'var_pathinfo' => 's',
));

