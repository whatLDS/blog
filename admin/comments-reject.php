<?php
 require_once '../functions.php';
 function reject_comments(){
    $id = $_GET['id'];
    $rejected='rejected';
    $rows = xiu_execute('update comments set status = '.'\''.'rejected'.'\''.'where id in (' . $id . ');');
    // $rows = xiu_execute('delete from comments where id in (' . $id . ');');
    // delete from categories where id in (' . $id . ');
    // $rows = xiu_execute("update categories set slug = '{$slug}', name = '{$name}' where id = {$id}");

  $GLOBALS['success'] = $rows > 0;
  $GLOBALS['message'] = $rows <= 0 ? '批准失败！' : '批准成功！';
  }
// => '1 or 1 = 1'
// sql 注入
// 1,2,3,4
 if (isset($_GET['id'])) {
    reject_comments();
  }else{
  	exit('缺少必要参数');
  }
  header('Location: /admin/comments.php');