<?php

/*=============================================================================
#     FileName: file.php
#         Desc:
#       Author: Lolly
#        Email: cclolly@gmail.com
#     HomePage:
#      Version: 0.0.1
#   LastChange: 2016-09-19 01:14:33
#      History:
=============================================================================*/

/**
 * @time 09/19/2016
 * @demo rename_file('./a', './b');
 */
function rename_file($source, $target)
{
  if (copy($source, $target)) {
    return unlink($source);
  } else {
    return false;
  }
}

