<?php

/*=============================================================================
#     FileName: array.php
#         Desc:
#       Author: Lolly
#        Email: cclolly@gmail.com
#     HomePage:
#      Version: 0.0.1
#   LastChange: 2016-09-20 03:20:48
#      History:
=============================================================================*/

/**
 * @info   获取前 N 个元素
 * @param  (array) $array
 * @param  (int)   $top
 * @return (array) $array
 *
 * @author Lolly <cclolly@gmail.com>
 * @time   20140801025149
 */
function top($array, $top = 1)
{
  array_splice($array, $top);
  return $array;
}

/**
 * @info   根据 key 获取数组值
 * @param  (array)        $array  数组
 * @param  (string)       $key    要获得数据的键
 * @param  (mixed)        $type   类型 [false: 数组, string: 参数做分隔符]
 * @return (array|string) $result
 *
 * @author Lolly <cclolly@gmail.com>
 * @time   20140728163852
 */
function get_value($array, $key, $type = false)
{
  $key = trim($key);
  if (empty($key)) {
    return false;
  }
  preg_match_all("/\"$key\";\w{1}:(?:\d+:|)(.*?);/", serialize($array), $result);
  if (!$type) {
    return $result[1];
  } else {
    return str_replace("\"", "", implode($type, $result[1]));
  }
}

/**
 * @info   不改变键值的打乱数组
 * @param  (array)   $_array
 * @param  (boolean) $unique 过滤重复数组
 * @return (array)
 *
 * @author Lolly <cclolly@gmail.com>
 * @time   20140728165521
 */
function upset($_array, $unique = false)
{
  $array = array();
  $array_return = array();

  foreach ($_array as $key => $val) {
    $array[] = array($key => $val);
  }
  shuffle($array);
  foreach ($array as $value) {
    $array_return[key($value)] = current($value);
  }
  if ($unique) {
    $array_return = array_unique($array_return);
  }
  return $array_return;
}

/**
 * @info   压缩数组，过滤所有空值
 * @param  (array) $array
 * @return (array) $array
 *
 * @author Lolly <cclolly@gmail.com>
 * @time   20140802000730
 */
function compress($array)
{
  $string = json_encode($array);
  // 空数组 []
  $string = str_replace('[]', '', $string);
  $string = preg_replace('/("(\w*?)":null)|("(\w*?)":"")/', '', $string);
  // 多个逗号合成一个
  $string = preg_replace('/"(,+)"/', '","', $string);
  // 边界 ,} ,] 去除逗号
  $string = preg_replace('/{(,+)/', '{', $string);
  $string = preg_replace('/(,+)}/', '}', $string);
  $string = preg_replace('/\[(,+)/', '[', $string);
  $string = preg_replace('/(,+)\]/', ']', $string);
  return json_decode($string, true);
}

/**
 * @info   指定键值做键名
 * @access public
 * @param  (array)  $array
 * @param  (string) $index 数组中某个键名
 * @return (array)  $array
 *
 * @author Lolly <cclolly@gmail.com>
 * @time   20140718174224
 */
function index($_array, $index = 'id')
{
  $array = array();
  foreach ($_array as $key => $item) {
    $array[$item[$index]] = $item;
  }
  return $array;
}

/**
 * @info   无限分类树形格式化
 * @access public
 * @param  (array)  $items 原始一维数组
 * @param  (string) $id    主要id
 * @param  (string) $cid   归属id
 * @param  (string) $mark  归档键名
 * @return (array)  $array
 * @model  gen_tree($array, 'id', 'cid', 'son') // => (array) $array
 *
 * @time   20140718174224
 */
function gen_tree($array, $id = 'id', $cid = 'cid', $mark = 'items') {
  foreach ($array as $item) {
    $array[$item[$cid]][$mark][$item[$id]] = &$array[$item[$id]];
  }
  return isset($array[0][$mark]) ? $array[0][$mark] : array();
}

/**
 * @info   获得数组深度
 * @access public
 * @param  (array) $array
 * @return (int)   $max_depth
 *
 * @author Lolly <cclolly@gmail.com>
 * @time   20140718174224
 */
function depth($array)
{
  $max_depth = 1;
  foreach ($array as $value) {
    if (is_array($value)) {
      $depth = depth($value) + 1;
      if ($depth > $max_depth) {
        $max_depth = $depth;
      }
    }
  }
  return $max_depth;
}

/**
 * @info   数组按字段排序
 * @access public
 * @param  (array)  $array
 * @param  (string) $field 排序索引字段
 * @param  (string) $sort  排序方向 ['ASC'|'DESC']
 * @return (array)  $array
 *
 * @author Lolly <cclolly@gmail.com>
 * @time   20140718174224
 */
function array_sort($array, $field, $sort = 'asc')
{
  foreach ($array as $item) {
    $by[] = @$item[$field];
  }
  // array_multisort 数字键名会被重新索引
  switch (strtoupper($sort)) {
  case 'ASC':
    array_multisort($by, SORT_ASC, SORT_NUMERIC, $array);
    break;

  case 'DESC':
    array_multisort($by, SORT_DESC, SORT_NUMERIC, $array);
    break;

  default:
    break;
  }
  return $array;
}

/**
 * @info   值是否存在于数组中
 * @param  (mixed)   $value
 * @param  (array)   $array
 * @param  (string)  $mode  [case: 不分大小写]
 * @return (boolean)
 */
function value_in_array($value, $array, $mode = false)
{
  switch ($mode) {
  case 'case':
    $result = in_array(strtolower($value), array_map('strtolower', $array));
    break;

  default:
    $result = in_array($value, $array);
    break;
  }
  return $result;
}

/**
 * @info   将数组转换成请求的字符串编码并且还原
 * @param  (array)  $array
 * @param  (string) $in_charset
 * @param  (string) $out_charset
 * @return (array)  $array
 * @error  如果输入编码不对，会直接报错。eval 运行出错没法屏蔽。
 *
 * @author Lolly <cclolly@gmail.com>
 * @time   20140801010640
 */
function array_iconv($array, $in_charset, $out_charset)
{
  eval('$array = ' . iconv($in_charset, $out_charset, var_export($array, true)) . ';');
  return $array;
}

/* EOF array.php */
/* vim:set ft=php ts=2 sw=2 et fdm=marker: */
