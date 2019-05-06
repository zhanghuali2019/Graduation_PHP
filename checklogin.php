<?php
header("Access-Control-Allow-Origin:http://localhost:8080");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
header('Content-Type:application/json; charset=utf-8');
//session_start();
$username = $_POST['username'];
$password = $_POST['password'];
// 验证
if($username == '') {
    $arr4 = array('is_login' => false,'message' => '用户名不能为空');
	$json4 = json_encode($arr4);
	exit($json4);
} else if($password == '') {
    $arr5 = array('is_login' => false,'message' => '密码不能为空');
	$json5 = json_encode($arr5);
	exit($json5);
}
// 连接数据库
$conn = @mysqli_connect('localhost', 'root', '', 'bbs');
// 检测连接是否有错
if (mysqli_connect_errno() !== 0) {
    die(mysqli_connect_error());
}

$sql = "SELECT * FROM `user` WHERE `username` = '" . $username . "'";
$result = mysqli_query($conn, $sql);
if(mysqli_errno($conn) !== 0) {
    die(mysqli_error($conn));
}
$user = mysqli_fetch_assoc($result);

if(!$user) {
    $arr1 = array('is_login' => false,'message' => '用户不存在');
	$json1 = json_encode($arr1);
	exit($json1);
}

if($password != $user['password']) {
    $arr2 = array('is_login' => false,'message' => '密码错误');
	$json2 = json_encode($arr2);
	exit($json2);
}

//$_SESSION['is_login'] = 1;
//$_SESSION['user'] = $user;
$arr3 = array('is_login' => true,'username' => $user['username']);
$json3 = json_encode($arr3);
exit($json3);

//header('Location: http://localhost:8080/');
