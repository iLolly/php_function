<?php

/*=============================================================================
#     FileName: rename.php
#         Desc:
#       Author: Lolly
#        Email: cclolly@gmail.com
#     HomePage:
#      Version: 0.0.1
#   LastChange: 2016-07-28 16:02:16
#      History:
=============================================================================*/

function rename_file($source, $target)
{
  if (copy($source, $target)) {
    return unlink($source);
  } else {
    return false;
  }
}

echo rename_file('./a.txt', './b.txt');

