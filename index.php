
<?php
require ('./mysqli_connect.php');
$pagesize = 3;//设置每页显示的留言数量
$page = isset($_GET['page']) ? $_GET['page'] : 1 ; //判断当前的页数，如果不知道就默认是第一页
$sql = "SELECT article_name FROM article WHERE id=1"; //从数据库中查询留言，首先查看置顶留言，再根据id倒序查询留言
$result = mysqli_query($link, $sql); //将上一步对数据库的查询结果返回给$result
$row=mysqli_fetch_assoc($result);
$s = $row['article_name'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>留言板</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
<div class="background">
    <!-- 提交留言的表单 -->
    <div class="transbox">
        <br />
        <h3>文章标题：<?php echo $s ?></h3>
        <h3>留言板</h3>
        <form class="form" action="mes_insert.php" method="post">
            <p class=username>昵称：<br /><input type="text" name="username" placeholder="请输入昵称，匿名可为空"/></p>
            <p class=content>留言：<br /><textarea name="content" cols="25" rows="5"></textarea></p>
            <p><input type="submit" value="马上留言" /></p>
        </form>        
    <!-- 分割线 -->
    <hr/>
<?php
//分页
$pagesize = 30;//设置每页显示的留言数量
$page = isset($_GET['page']) ? $_GET['page'] : 1 ; //判断当前的页数，如果不知道就默认是第一页
$sql = "SELECT * FROM message WHERE is_reported=0 ORDER BY is_toped DESC,id DESC"; //从数据库中查询留言，首先查看置顶留言，再根据id倒序查询留言
$result = mysqli_query($link, $sql); //将上一步对数据库的查询结果返回给$result
$rows_count = mysqli_num_rows($result); //将留言总条数赋值给$rowa_count
$page_count = ceil($rows_count / $pagesize); //计算留言总页数

$start = ($page-1) * $pagesize; //计算当前页数留言从哪条开始输出
$sql .= " LIMIT $start,$pagesize"; //根据上一条sql语句限制留言数量的输出
$result = mysqli_query($link, $sql); //将上一条对数据库的操作重新赋值给$result
//输出已发布的留言，并且显示删除、修改、置顶、举报、点赞等功能
while($row=mysqli_fetch_assoc($result)){
    echo "<p>{$row['id']}# {$row['username']} 于 {$row['time']}说：<br> {$row['content']}";
    // //显示删除功能
    // echo '<a href="mes_delete.php?id=' . $row['id'] . '">删除 |</a>';
    // //显示修改功能
    // echo '<a href="mes_modify.php?id=' . $row['id'] . '"> 修改 |</a>';
    // //显示置顶功能
    // if($row['id_toped']){
    //     echo '<a href="mes_action.php?mes_act=canceltop&id=' . $row['id'] . '"> 取消置顶 |</a>';
    // } else {
    //     echo '<a onclick="myFunctionTop()" href="mes_action.php?mes_act=settop&id=' . $row['id'] . '"> 置顶 |</a>';
    // }
        //显示点赞功能
        echo '<a href="mes_action.php?mes_act=praise&id=' . $row['id'] . '"> 点赞(' . $row['is_praised'] . ') </a>';
    //显示举报功能
    echo '<a href="mes_action.php?mes_act=report&id=' . $row['id'] . '"> 举报 |</a>';
    echo '</p>';
}
//打印页码数
for($i=1; $i<=$page_count; $i++) {
    echo '<a href="index.php?page='.$i.'">'; //传值给$page
    echo ' ' .$i. ' ';
    echo '</a>'; 
}
?>
</div>
</div>
</body>
</html>