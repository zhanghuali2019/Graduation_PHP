<?php
header("Access-Control-Allow-Origin:http://localhost:8080");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
header('Content-Type:application/json; charset=utf-8');

/*if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];
} else {
    die('参数错误,程序已终止!');
}*/
$tid=$_POST['id'];
// 连接数据库
$conn = @mysqli_connect('localhost', 'root', '', 'bbs');
// 检测连接是否有错
if (mysqli_connect_errno() !== 0) {
    die(mysqli_connect_error());
}

$sql = "DELETE FROM `thread` WHERE `id` = " . $tid;

mysqli_query($conn, $sql);

if(mysqli_errno($conn) !== 0) {
    die(mysqli_error($conn));
}

$res = array('is_success' => true);
$res_json = json_encode($res);
exit($res_json);


?>
