<?php
header('Content-Type:text/html; charset=utf-8');
//连接数据库文件
require ('./mysqli_connect.php');
//接收用户提交过来的信息
$username = $_POST['username'];
$content = $_POST['content'];
//简单验证用户提交的信息
// if(strlen($username)>=30 || strlen($username)<=4){
//     echo '请输入2-9个汉字之间的用户名！';
//     exit;
// }
$username=strFilter($username);
$content=strFilter($content);
if(strlen($content)<1){
    echo '留言内容不能为空！';
    exit;
}
//数据库插入语句
$sql = "INSERT INTO message (username, content, time) VALUES ('$username', '$content', now())";
//将上一步对数据库进行插入操作的结果返回并赋值给$result
$result = mysqli_query($link, $sql);
//如果成功跳转到主页面，失败报错
if($result){
    echo '<script>alert("恭喜你留言成功！");location.href="./index.php";</script>';
} else {
    echo "留言失败！<br>";
    echo mysqli_error($link);
    echo '<a href="./index.php">回到首页！</a>';
}



//php过滤字符串特殊符号
function strFilter($str){
    $regex = "'";
    $str = str_replace($regex, '', $str);
    return trim($str);
}