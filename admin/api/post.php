<?php
require_once "../../functions.php";

$page = isset($_GET['p']) && is_numeric($_GET['p']) ? intval($_GET['p']) : 1;

// 页大小
$size = isset($_GET['s']) && is_numeric($_GET['s']) ? intval($_GET['s']) : 20;

// 检查页码最小值
if ($page <= 0) {
  header('Location: /admin/post.php?p=1&s=' . $size);
  exit;
}

// 查询总条数
// $total_count = intval(xiu_fetch_all('select count(1) from posts
// ;'));
$total_count = intval(xiu_fetch_all('select count(1) as count from posts
;')[0]['count']);

// 计算总页数
$total_pages = ceil($total_count / $size);

// 检查页码最大值
if ($page > $total_pages) {
  // 跳转到最后一页
  header('Location: /admin/posts.php?p=' . $total_pages . '&s=' .$size);
  exit;
}

// 查询数据
// ========================================

// 分页查询评论数据
$posts = xiu_fetch_all(sprintf('select
  *  from posts order by posts.created desc
limit %d, %d;', ($page - 1) * $size, $size));

// 响应 JSON
// ========================================

// 设置响应类型为 JSON
header('Content-Type: application/json');

// 输出 JSON
echo json_encode(array(
  'success' => true,
  'data' => $posts,
  'total_count' => $total_count
));
