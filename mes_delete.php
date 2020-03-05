<?php
header('Content-Type:text; charset=utf-8');
//连接数据库
require ('./mysqli_connect.php');
//接收从index.php传过来的id
$id = $_GET['id'];
//对传过来的id进行简单的验证
if(!is_numeric($id)){
    echo "id不是数字！";
    exit;
}
//对数据库进行删除操作
$sql = "DELETE FROM message WHERE id={$id}";
//将上一步对数据库进行操作的结果返回并赋值给$result
$result = mysqli_query($link,$sql);
//如果成功跳转到主页面，失败报错
if($result){
    echo '<script>alert("恭喜你删除成功！");location.href="./index.php";</script>';
} else {
    echo '删除失败！<br>';
    echo mysqli_error($link);
    echo '<a href="./index.php">回到首页！</a>';
}