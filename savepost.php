<?php

header("Access-Control-Allow-Origin:http://localhost:8080");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
header('Content-Type:application/json; charset=utf-8');
session_start();
// 连接数据库
$conn = @mysqli_connect('localhost', 'root', '', 'bbs');
// 检测连接是否有错
if (mysqli_connect_errno() !== 0) {
    die(mysqli_connect_error());
}

$subject = $_POST['subject'];
$content = $_POST['content'];
$section_id = $_POST['section_id'];
$authcode = $_POST['authcode'];
$post_by = $_POST['post_by'];
$post_at = $_POST['post_at'];


// 查询数据库
$sql = "INSERT `post` (`id`,`section_id`,`subject`,`content`,`post_by`,`post_at`) VALUES (null, " . $section_id . ", '" . $subject . "', '" . $content . "', '" . $post_by . "', '" . $post_at . "')";
mysqli_query($conn, $sql);
if(mysqli_errno($conn) !== 0) {
    //die(mysqli_error($conn));
    $arr1 = array('is_success' => false, 'subject'=>$subject,'msg'=>mysqli_error($conn));
    $json1 = json_encode($arr1);
    exit($json1);
    
}

$arr3 = array('is_success' => true);
$json3 = json_encode($arr3);
exit($json3);