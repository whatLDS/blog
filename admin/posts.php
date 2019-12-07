<?php
require_once '../functions.php';

xiu_get_current_user();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
            <option value="">未分类</option>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="">草稿</option>
            <option value="">已发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
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
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'posts'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/jsrender/jsrender.js"></script>
  <script id="post_tmpl" type="text/x-jsrender">
    {{if success}}
    {{for data}}
    <tr  data-id="{{: id }}">
      <td class="text-center"><input type="checkbox"></td>
      <td>{{: title }}</td>
      <td>{{: user_id }}</td>
      <td>{{: category_id }}</td>
      <td>{{: created }}</td>
      <td>{{: status === 'held' ? '待审' : status === 'rejected' ? '拒绝' : '准许' }}</td>
      <td class="text-center">
        {{if status === 'held'}}
        <a class="btn btn-info btn-xs btn-edit" href="javascript:;" data-status="approved">批准</a>
        <a class="btn btn-warning btn-xs btn-edit" href="javascript:;" data-status="rejected">拒绝</a>
        {{/if}}
        <a class="btn btn-danger btn-xs btn-delete" href="javascript:;">删除</a>
      </td>
    </tr>
    {{/for}}
    {{else}}
    <tr>
      <td colspan="7">{{: message }}</td>
    </tr>
    {{/if}}
  </script>
  <script>
    $(function(){
      var $tmpl=$('#post_tmpl')
      var $tbody=$('tbody')
      var size=30
      $.get('/admin/api/post.php', {  s: size }, function (res) {
          // 通过模板引擎渲染数据
          var html = $tmpl.render(res)
          // 设置到页面中
          $tbody.html(html)
        })
    })
    
  </script>
  <script>NProgress.done()</script>
</body>
</html>
