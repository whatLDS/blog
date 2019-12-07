<?php
 include '../functions.php';
 function permit_comments(){
    $id = $_GET['id'];
    $rows = xiu_execute('update comments set status = '.'\''.'approved'.'\''.'where id in (' . $id . ');');

  $GLOBALS['success'] = $rows > 0;
  $GLOBALS['message'] = $rows <= 0 ? '批准失败！' : '批准成功！';
  }
// => '1 or 1 = 1'
// sql 注入
// 1,2,3,4
 if (isset($_GET['id'])) {
    permit_comments();
  }
$result=xiu_fetch_all('select * from comments');

?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>

    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none" id="btn_batch">
          <a class="btn btn-info btn-sm" id="btn_approve" href="/admin/comments.php">批量批准</a>
          <a class="btn btn-warning btn-sm" id="btn_reject" href="/admin/comments-reject.php">批量拒绝</a>
          <a class="btn btn-danger btn-sm" id="btn_delete" href="/admin/comments-delete.php">批量删除</a>
        </div>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="150">操作</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $comments): ?>
          <?php if ($comments['status']=='approved'): ?> <tr class="<?php echo'success' ?>" data-id="<?php echo $comments['id'];?>">
            <td class="text-center"><input type="checkbox" data-id="<?php echo $comments['id'] ?>"></td>
            <td><?php echo $comments['author'] ?></td>
            <td><?php echo $comments['content'] ?></td>
            <td><?php echo $comments['email'] ?></td>
            <td><?php echo $comments['created'] ?></td>
            <td><?php if ($comments['status']=='approved'): ?><?php echo'准许'?><?php endif ?><?php if ($comments['status']=='rejected'): ?><?php echo'拒绝' ?><?php endif ?><?php if ($comments['status']=='held'): ?>
                <?php echo'待审' ?><?php endif ?></td>
              <td class="text-center">
              <a href="<?php echo $_SERVER['PHP_SELF'].'?id='.$comments['id']?>" class="btn btn-info btn-xs">批准</a>
              <a href="comments-delete.php?id=<?php echo $comments['id'] ?>" class="btn btn-danger btn-xs">删除</a>
              <a href="comments-reject.php?id=<?php echo $comments['id'] ?>" class="btn btn-danger btn-xs">拒绝</a>
            </td>
          </tr>
        <?php endif ?>
        <?php if ($comments['status']=='rejected'): ?>
          <tr class="<?php echo'danger' ?>" data-id="<?php echo $comments['id'];?>">
            <td class="text-center"><input type="checkbox" data-id="<?php echo $comments['id'] ?>"></td>
            <td><?php echo $comments['author'] ?></td>
            <td><?php echo $comments['content'] ?></td>
            <td><?php echo $comments['email'] ?></td>
            <td><?php echo $comments['created'] ?></td>
            <td><?php if ($comments['status']=='approved'): ?><?php echo'准许'?><?php endif ?><?php if ($comments['status']=='rejected'): ?><?php echo'拒绝' ?><?php endif ?><?php if ($comments['status']=='held'): ?>
                <?php echo'待审' ?><?php endif ?></td>
              <td class="text-center">
              <a href="<?php echo $_SERVER['PHP_SELF'].'?id='.$comments['id']?>" class="btn btn-info btn-xs">批准</a>
              <a href="comments-delete.php?id=<?php echo $comments['id'] ?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
        <?php endif ?>
        <?php if ($comments['status']=='held'): ?>
          <tr class="<?php echo 'warning' ?>" data-id="<?php echo $comments['id'];?>">
           <td class="text-center"><input type="checkbox" data-id="<?php echo $comments['id'] ?>"></td>
            <td><?php echo $comments['author'] ?></td>
            <td><?php echo $comments['content'] ?></td>
            <td><?php echo $comments['email'] ?></td>
            <td><?php echo $comments['created'] ?></td>
            <td><?php if ($comments['status']=='approved'): ?><?php echo'准许'?><?php endif ?><?php if ($comments['status']=='rejected'): ?><?php echo'拒绝' ?><?php endif ?><?php if ($comments['status']=='held'): ?>
                <?php echo'待审' ?><?php endif ?></td>
              <td class="text-center">
              <a href="<?php echo $_SERVER['PHP_SELF'].'?id='.$comments['id']?>" class="btn btn-info btn-xs">批准</a>
              <a href="comments-delete.php?id=<?php echo $comments['id'] ?>" class="btn btn-danger btn-xs">删除</a>
              <a href="comments-reject.php?id=<?php echo $comments['id'] ?>" class="btn btn-danger btn-xs">拒绝</a>
            </td>
          </tr>
        <?php endif ?>
        <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'comments'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script type="text/javascript">
     $(function($){
      var tbodyCheckboxs = $('tbody input')
      var btnDelete = $('#btn_delete')
      var btnApprove=$('#btn_approve')
      var btnReject=$('#btn_reject')
      var btnBatch=$('#btn_batch')
      var allCheckeds = []
      $('input').on("change",function(){
        var id=$(this).data('id');
        if($(this).prop('checked')){
          allCheckeds.push(id)
        }else{
          allCheckeds.splice(allCheckeds.indexOf(id), 1)
        }
        allCheckeds.length ? btnBatch.fadeIn() : btnBatch.fadeOut()
        console.log(allCheckeds);
        btnDelete.prop('search', '?id=' + allCheckeds)
        btnApprove.prop('search', '?id=' + allCheckeds)
        btnReject.prop('search', '?id=' + allCheckeds)
      })

     })
    //    $(function ($) {
    //   // 在表格中的任意一个 checkbox 选中状态变化时
    //   var $tbodyCheckboxs = $('tbody input')
    //   var $btnDelete = $('#btn_delete')

    //   // 定义一个数组记录被选中的
    //   var allCheckeds = []
    //   $tbodyCheckboxs.on('change', function () {
    //     // this.dataset['id']
    //     // console.log($(this).attr('data-id'))
    //     // console.log($(this).data('id'))
    //     var id = $(this).data('id')

    //     // 根据有没有选中当前这个 checkbox 决定是添加还是移除
    //     if ($(this).prop('checked')) {
    //       allCheckeds.push(id)
    //     } else {
    //       allCheckeds.splice(allCheckeds.indexOf(id), 1)
    //     }

    //     // 根据剩下多少选中的 checkbox 决定是否显示删除
    //     allCheckeds.length ? $btnDelete.fadeIn() : $btnDelete.fadeOut()
    //     $btnDelete.prop('search', '?id=' + allCheckeds)
    //   })

    //   // ## version 1 =================================
    //   // $tbodyCheckboxs.on('change', function () {
    //   //   // 有任意一个 checkbox 选中就显示，反之隐藏
    //   //   var flag = false
    //   //   $tbodyCheckboxs.each(function (i, item) {
    //   //     // attr 和 prop 区别：
    //   //     // - attr 访问的是 元素属性
    //   //     // - prop 访问的是 元素对应的DOM对象的属性
    //   //     // console.log($(item).prop('checked'))
    //   //     if ($(item).prop('checked')) {
    //   //       flag = true
    //   //     }
    //   //   })

    //   //   flag ? $btnDelete.fadeIn() : $btnDelete.fadeOut()
    //   // })
    // })

  </script>
</body>
</html>
