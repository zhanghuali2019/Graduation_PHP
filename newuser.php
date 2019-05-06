<?php
header("Access-Control-Allow-Origin:http://localhost:8080");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
header('Content-Type:application/json; charset=utf-8');
// 连接数据库
$conn = @mysqli_connect('localhost', 'root', '', 'bbs');
// 检测连接是否有错
if (mysqli_connect_errno() !== 0) {
    die(mysqli_connect_error());
}

// print_r($_POST);

$username = $_POST['username'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$nickname = $_POST['nickname'];
$email = $_POST['email'];


// 数据验证
if($username == '') {
    $arr1 = array('is_regist' => false,'message' => '用户名不能为空');
	$json1 = json_encode($arr1);
	exit($json1);
} else if($password == '') {
    $arr2 = array('is_regist' => false,'message' => '密码不能为空');
	$json2 = json_encode($arr2);
	exit($json3);
} else if(strlen($password) < 6) {
    $arr3 = array('is_regist' => false,'message' => '密码长度少于6位');
	$json3 = json_encode($arr3);
	exit($json3);
} else if($password !== $password_confirm) {
    $arr4 = array('is_regist' => false,'message' => '两次输入密码不同');
	$json4 = json_encode($arr4);
	exit($json4);
} else if($nickname == '') {
    $arr5 = array('is_regist' => false,'message' => '昵称不能为空');
	$json5 = json_encode($arr5);
	exit($json5);
} else if($email == '') {
    $arr6 = array('is_regist' => false,'message' => '邮箱不能为空');
	$json6 = json_encode($arr6);
	exit($json6);
}

//检测该用户名是否被注册过
$sql1 = "SELECT * FROM `user` WHERE `username` = '" . $username . "'";
$result1 = mysqli_query($conn, $sql1);
if(mysqli_errno($conn) !== 0) {
    die(mysqli_error($conn));
}
$user1 = mysqli_fetch_assoc($result1);

if($user1) {
    $arr8 = array('is_resgit' => false,'message' => '用户名已被注册');
	$json8 = json_encode($arr8);
	exit($json8);
}

// 查询数据库
$sql = "INSERT `user` (`avatar`,`id`,`username`,`password`,`nickname`,`email`) VALUES ('../a/a.png',null, '" . $username . "', '" . $password . "', '" . $nickname . "', '" . $email . "')";

mysqli_query($conn, $sql);

if(mysqli_errno($conn) !== 0) {
    die(mysqli_error($conn));
}

$arr7 = array('is_regist' => true,'message' => '注册成功');
$json7 = json_encode($arr7);
exit($json7);

?>
