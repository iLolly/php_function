<?php

/*=============================================================================
#     FileName: file.php
#         Desc:
#       Author: Lolly
#        Email: cclolly@gmail.com
#     HomePage:
#      Version: 0.0.1
#   LastChange: 2016-09-19 02:01:46
#      History:
=============================================================================*/

/**
 * @time   09/19/2016T01:21
 * @return (boolean)
 * @demo   rename_file('./a', './b');
 */
function rename_file($source, $target)
{
  if (copy($source, $target)) {
    return unlink($source);
  } else {
    return false;
  }
}

/**
 * @time   09/19/2016T02:07
 * @param  (string) $path
 * @return (mixed)
 */
function get_require($path)
{
  if (is_file($path)) return require $path;
}

function put($path, $contents)
{
  return file_put_contents($path, $contents);
}

/**
 * @time   09/19/2016T01:50
 * @return (int)
 */
function prepend($path, $data)
{
  if (file_exists($path)) {
    return file_put_contents($path, $data . file_get_contents($path));
  } else {
    return file_put_contents($path, $data);
  }
}

/**
 * @time   09/19/2016T01:56
 * @return (int)
 */
function append($path, $data)
{
  return file_put_contents($path, $data, FILE_APPEND);
}

/**
 * @time   09/19/2016T01:58
 * @return (int)
 */
function last_modified($path)
{
  return filemtime($path);
}

/**
 * @time   09/19/2016T01:58
 * @param  (string|array) $paths
 * @return (int)
 */
function delete($paths)
{
  $paths = is_array($paths) ? $paths : func_get_args();
  $count = 0;
  foreach ($paths as $path) {
    if (@unlink($path)) {
      $count += 1;
    }
  }
  return $count;
}

/**
 * @time   09/19/2016T01:50
 * @return (boolean)
 */
function move($path, $target)
{
  return rename($path, $target);
}

/**
 * @time   09/19/2016T01:50
 * @return (string)
 */
function type($path)
{
  return filetype($path);
}

/**
 * @time   09/19/2016T02:00
 * @return (int)
 */
function size($path)
{
  return filesize($path);
}

/* EOF file.php */
/* vi:set ft=php ts=2 sw=2 et fdm=marker: */
