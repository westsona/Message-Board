<?php
header('Content-Type:text/html; charset=utf-8');
//连接数据库文件
require ('./mysqli_connect.php');
//接收用户提交过来的信息
$username = $_POST['username'];
$content = $_POST['content'];
$article_id = $_POST['article_id'];
//简单验证用户提交的信息
// if(strlen($username)>=30 || strlen($username)<=4){
//     echo '请输入2-9个汉字之间的用户名！';
//     exit;
// }
$username=strFilter($username);
$content=strFilter($content);
$order_index_sql = "SELECT article_id FROM message WHERE article_id=$article_id"; //从数据库中查询留言，首先查看置顶留言，再根据id倒序查询留言
$order_index_result = mysqli_query($link, $order_index_sql); //将上一步对数据库的查询结果返回给$result
$order_index_count = mysqli_num_rows($order_index_result); //将留言总条数赋值给$rowa_count
$order_index_count=$order_index_count+1;
if(strlen($username)<1){
    $username='匿名用户';
}
if(strlen($content)<1){
    echo '留言内容不能为空！';
    exit;
}
//数据库插入语句
$sql = "INSERT INTO message (username, content, time, article_id, order_index) VALUES ('$username', '$content', now(), $article_id, $order_index_count)";
//将上一步对数据库进行插入操作的结果返回并赋值给$result
$result = mysqli_query($link, $sql);
//如果成功跳转到主页面，失败报错
if($result){
    // echo '<script>alert("恭喜你留言成功！");location.href="./index.php?$article_id";</script>';
    //重定向浏览器
    echo '<script>alert("恭喜你留言成功！")</script>';
    header("Location:./index.php?article=$article_id");
    //确保重定向后，后续代码不会被执行
    exit;
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